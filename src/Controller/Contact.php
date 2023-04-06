<?php

namespace App\Src\Controller;

use App\Src\Form\ContactForm;
use App\Src\Repository\ContactRepository;
use App\Src\Service\MailService;
use App\Src\Validator\ContactValidator;
use PHPMailer\PHPMailer\Exception;

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

        if ($this->valideForm($request, 'contact', 'contact') === TRUE) {
            $contact = new \App\Src\Entity\Contact("default");
            $contact->setName($request->get('post', 'name'));
            $contact->setMail($request->get('post', 'mail'));
            $contact->setMessage($request->get('post', 'message'));

            $mailValidator = new ContactValidator($contact);

            $validate = $mailValidator->validate();

            if ($validate === true) {
                $contactRepository = new ContactRepository();

                $contactRepository->insert($contact);
                $this->session->setFlash('success', "Demande de contact envoyé");
                $this->redirectTo('/');
            }
        }

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $contactForm->contact($validate, $token);

        $this->render(
            'contact/contact', [
                'form' => $form->create()
            ]
        );

    }//end index()


    /**
     * Page pour voir toutes les demandes de contact
     *
     * @return void
     */
    public function listContact()
    {

        if ($this->session->getAuth('level') < 60) {
            $this->redirectTo('/');
        }

        $this->render('contact/listContact');

    }

    /**
     * Formulaire pour répondre aux demandes de contact
     *
     * @param int $idContact parameter
     * @return void
     * @throws Exception
     */
    public function answerContact(int $idContact)
    {

        if ($this->session->getAuth('level') < 60) {
            $this->redirectTo('/');
        }

        $request = new Request();
        $contactForm = new ContactForm();
        $contactRepository = new ContactRepository();
        $contact = $contactRepository->find($idContact);
        $validate = [];

        if ($this->valideForm($request, 'answer', 'Contact/answerContact/'.$idContact) === TRUE) {
            $contact->setProcess('answer');
            $contact->setProcessAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $contact->setProcessBy($this->session->getAuth('user_id'));
            $contact->setAnswer($request->get('post', 'answer'));

            $contactValidator = new ContactValidator($contact);

            $validate = $contactValidator->validateAnswer();

            if ($validate === true) {
                $message = 'Votre message : <br>'.$contact->getMessage().'<br><br>Notre réponse : <br>'.$contact->getAnswer();

                $mailService = new MailService($contact->getMail(), "Réponse à votre demande de contact du ".date_create_from_format('Y-m-d H:i:s', $contact->getCreatedAt())->format('d-m-Y à H:i'), $message, $contact->getName());

                if ($mailService->send() === TRUE) {
                    $contactRepository->update($contact);
                    $this->session->setFlash('success', "Réponse envoyé");
                    $this->redirectTo('/');
                }

                $this->session->setFlash('danger', "Réponse non envoyé");
                $this->redirectTo('/Contact/answerContact/'.$idContact);

            }//end if()

        }

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $contactForm->answer($validate, $token, $idContact);

        $this->render(
            'contact/answerContact',
            [
                'form' => $form->create(),
                'contact' => $contact,
            ]
        );
    }

    /**
     * Formulaire pour archiver les demandes de contact
     *
     * @param int $idContact parameter
     * @return void
     */
    public function archiveContact(int $idContact)
    {

        if ($this->session->getAuth('level') < 60) {
            $this->redirectTo('/');
        }

        $contactRepository = new ContactRepository();
        $contact = $contactRepository->find($idContact);

        $contact->setProcess('archived');
        $contact->setProcessAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
        $contact->setProcessBy($this->session->getAuth('user_id'));

        $contactRepository->update($contact);
        $this->session->setFlash('success', "Demande de contact archivé");
        $this->redirectTo('/Contact/listContact');
    }

    /**
     * Fonction qui définit ce qui sera afficher dans la liste des demandes de contact
     *
     * @param int $choice parameter
     * @return void
     */
    public function choiceBox(int $choice)
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

        $this->render(
            'contact/box',
            [
                'contacts' => $contacts
            ]
        );
    }
}
