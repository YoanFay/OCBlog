<?php

namespace App\Src\Controller;

use App\Src\Form\ContactForm;
use App\Src\Repository\ContactRepository;
use App\Src\Service\MailService;
use App\Src\Validator\ContactValidator;

class Contact extends Controller
{

    /**
     * Formulaire pour faire une demande de contact
     *
     * @return void
     */
    public function index()
    {
        $contactForm = new ContactForm();
        $validate = [];
        $request = new Request();


        if ($this->valideForm($request, 'contact', 'contact')) {

            $contact = new \App\Src\Entity\Contact("default");
            $contact->setName($request->get('post', 'name'));
            $contact->setMail($request->get('post', 'mail'));
            $contact->setMessage($request->get('post', 'message'));

            $mailValidator = new ContactValidator($contact);

            $validate = $mailValidator->validate();

            if ($validate === true) {
                $contactRepository = new ContactRepository();

                $contactRepository->insert($contact);
                Session::setFlash('success', "Demande de contact envoyé");
                header('Location: /');
            }
        }

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $contactForm->contact($validate, $token);

        $this->render('contact/contact', [
            'form' => $form->create()
        ]);
    }

    /**
     * Page pour voir toutes les demandes de contact
     *
     * @return void
     */
    public function listContact()
    {

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $this->render('contact/listContact');
    }

    /**
     * Formulaire pour répondre aux demandes de contact
     *
     * @return void
     */
    public function answerContact(int $id)
    {

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $request = new Request();
        $contactForm = new ContactForm();
        $contactRepository = new ContactRepository();
        $contact = $contactRepository->find($id);
        $validate = [];

        if ($this->valideForm($request, 'answer', 'Contact/answerContact/' . $id)) {
            $contact->setProcess('answer');
            $contact->setProcessAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $contact->setProcessBy(Session::getAuth('user_id'));
            $contact->setAnswer($request->get('post', 'answer'));

            $contactValidator = new ContactValidator($contact);

            $validate = $contactValidator->validateAnswer();

            if ($validate === true) {
                $message = 'Votre message : <br>' . $contact->getMessage() . '<br><br>Notre réponse : <br>' . $contact->getAnswer();

                $mailService = new MailService($contact->getMail(), "Réponse à votre demande de contact du " . date_create_from_format('Y-m-d H:i:s', $contact->getCreatedAt())->format('d-m-Y à H:i'), $message, $contact->getName());

                if ($mailService->send()) {
                    $contactRepository->update($contact);
                    Session::setFlash('success', "Demande de contact envoyé");
                    header('Location: /');
                } else {
                    Session::setFlash('danger', "Demande de contact non envoyé");
                    header('Location: /Contact/answerContact/' . $id);
                }

            }
        }

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $contactForm->answer($validate, $token, $id);

        $this->render('contact/answerContact', [
            'form' => $form->create(),
            'contact' => $contact,
        ]);
    }

    /**
     * Formulaire pour archiver les demandes de contact
     *
     * @return void
     */
    public function archiveContact(int $id)
    {

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $contactRepository = new ContactRepository();
        $contact = $contactRepository->find($id);

        $contact->setProcess('archived');
        $contact->setProcessAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
        $contact->setProcessBy(Session::getAuth('user_id'));

        $contactRepository->update($contact);
        Session::setFlash('success', "Demande de contact archivé");
        header('Location: /Contact/listContact');
    }

    /**
     * Fonction qui définit ce qui sera afficher dans la liste des demandes de contact
     *
     * @return void
     */
    public function choiceBox($choice)
    {

        $contactRepository = new ContactRepository();


        switch ($choice) {
            case 1:
                $contacts = $contactRepository->findNotProcess();
                break;
            case 2:
                $contacts = $contactRepository->findAnswer();
                break;
            case 3:
                $contacts = $contactRepository->findArchive();
                break;
            default:
                $contacts = $contactRepository->findNotProcess();
        }

        $this->render('contact/box', [
            'contacts' => $contacts
        ]);
    }
}