<?php

namespace App\Src\Controller;

use App\Src\Core\Bdd;
use App\Src\Core\Form;
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

        if ($this->valideForm($request, 'signUp', 'Authentication/signUp')) {

            $role = $roleRepository->findOneBy(['code' => 'user']);

            $user = new User();

            $user->setFirstname($request->get('post', 'firstname'));
            $user->setLastname($request->get('post', 'lastname'));
            $user->setLogin($request->get('post', 'login'));
            $user->setPassword(password_hash($request->get('post', 'password'), PASSWORD_BCRYPT));
            $user->setRoleId($role->getId());

            if ($request->get('post', 'avatar')) {
                $file = new File($request->get('file', 'image'));

                $fileValidator = new FileValidator($file);

                $testFile = $fileValidator->validateImage();
            } else {
                $testFile = 'default';
            }

            $userValidator = new UserValidator($user);

            $validate = $userValidator->validate();

            if ($validate === true) {

                if ($testFile === true) {
                    if ($filename = UploadService::uploadUser($file)) {
                        $user->setAvatar($filename);
                    } else {
                        Session::setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    }
                } elseif ($testFile === 'default') {
                    if ($filename = UploadService::uploadDefaultUser($user->getFirstname(), $user->getLastname())) {
                        $user->setAvatar($filename);
                    } else {
                        Session::setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    }
                }

                $userRepository = new UserRepository();
                $userRepository->add($user);

                header('Location: /Authentication/signIn');
            }
        }

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $authenticationForm->signUp($token, $testFile, $validate);

        $this->render('authentication/signUp', [
            'form' => $form->create()
        ]);
    }

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

        if ($this->valideForm($request, 'signIn', 'Authentication/signIn')) {

            $login = $request->get('post', 'login');
            $password = $request->get('post', 'password');

            $user = $userRepository->findOneBy(['login' => $login]);
            $role = $roleRepository->find($user->getRoleId());

            if (password_verify($password, $user->getPassword())) {
                Session::setAuth($user, $role);
                header('Location: /');
            }
        }

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $authenticationForm->signIn($token);

        $this->render('authentication/signIn', [
            'form' => $form->create()
        ]);
    }

    public function logout()
    {
        Session::logout();
        header('Location: /');
    }
}