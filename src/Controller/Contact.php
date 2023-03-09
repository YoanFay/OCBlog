<?php

namespace App\Src\Controller;

use App\Src\Form\ContactForm;
use App\Src\Repository\ContactRepository;
use App\Src\Validator\ContactValidator;

class Contact extends Controller
{

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

    public function listContact()
    {

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $contactRepository = new ContactRepository();
        $contacts = $contactRepository->findNotProcess();

        $this->render('contact/listContact', [
            'contacts' => $contacts
        ]);
    }
}