<?php

namespace App\Src\Controller;

use App\Src\Entity\File;
use App\Src\Entity\User;
use App\Src\Form\AuthentificationForm;
use App\Src\Repository\RoleRepository;
use App\Src\Repository\UserRepository;
use App\Src\Service\UploadService;
use App\Src\Validator\FileValidator;
use App\Src\Validator\UserValidator;

class Authentication extends Controller
{


    /**
     * Formulaire d'inscription
     *
     * @return void
     */
    public function signUp()
    {

        $roleRepository = new RoleRepository();
        $authenticationForm = new AuthentificationForm();
        $testFile = [];
        $validate = [];
        $request = new Request();

        if ($this->valideForm($request, 'signUp', 'Authentication/signUp') === TRUE) {
            $role = $roleRepository->findOneBy(['code' => 'user']);

            $user = new User();

            $user->setFirstname($request->get('post', 'firstname'));
            $user->setLastname($request->get('post', 'lastname'));
            $user->setLogin($request->get('post', 'login'));
            $user->setPassword(password_hash($request->get('post', 'password'), PASSWORD_BCRYPT));
            $user->setRoleId($role->getId());
            $testFile = 'default';
            $file = null;

            if ($request->get('post', 'avatar') === TRUE) {
                $file = new File($request->get('file', 'image'));

                $fileValidator = new FileValidator($file);

                $testFile = $fileValidator->validateImage();
            }

            $userValidator = new UserValidator($user);

            $validate = $userValidator->validate();

            if ($validate === true) {
                $uploadService = new UploadService();
                if ($testFile === true) {
                    $this->session->setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    if ($filename = $uploadService->uploadUser($file)) {
                        $user->setAvatar($filename);
                        $this->session->resetFlash();
                    }
                } else if ($testFile === 'default') {
                    $this->session->setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    if ($filename = $uploadService->uploadDefaultUser($user->getFirstname(), $user->getLastname())) {
                        $this->session->resetFlash();
                        $user->setAvatar($filename);
                    }
                }

                $userRepository = new UserRepository();
                $userRepository->add($user);

                $this->session->setFlash('success', "Inscription réussi");

                $this->redirectTo('/Authentication/signIn');
            }//end if
        }

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $authenticationForm->signUp($token, $testFile, $validate);

        $this->render(
            'authentication/signUp',
            [
                'form' => $form->create()
            ]
        );

    }//end signUp()


    /**
     * Formulaire de connexion
     *
     * @return void
     */
    public function signIn()
    {

        $userRepository = new UserRepository();
        $roleRepository = new RoleRepository();
        $authenticationForm = new AuthentificationForm();
        $request = new Request();

        if ($this->valideForm($request, 'signIn', 'Authentication/signIn') === TRUE) {
            $login = $request->get('post', 'login');
            $password = $request->get('post', 'password');

            $user = $userRepository->findOneBy(['login' => $login]);
            $role = $roleRepository->find($user->getRoleId());

            if (password_verify($password, $user->getPassword()) === TRUE) {
                $this->session->setAuth($user, $role);
                $this->redirectTo('/');
            }
        }

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $authenticationForm->signIn($token);

        $flash = $this->session->getFlash();
        $this->session->resetFlash();

        $this->render(
            'authentication/signIn',
            [
                'form' => $form->create(),
                "flash" => $flash
            ]
        );

    }//end signIn()


    /**
     * Fonction de déconnexion
     *
     * @return void
     */
    public function logout()
    {

        $this->session->logout();
        $this->redirectTo('/');

    }//end logout()


}
