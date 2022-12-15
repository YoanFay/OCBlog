<?php

namespace App\Src\Controller;

use App\Src\Core\Bdd;
use App\Src\Core\Form;
use App\Src\Entity\User;
use App\Src\Form\AuthentificationForm;
use App\Src\Repository\RoleRepository;
use App\Src\Repository\UserRepository;

class Authentication extends Controller{

    public function signUp(){

        $userRepository = new UserRepository();
        $roleRepository = new RoleRepository();
        $authenticationForm = new AuthentificationForm();

        if (!empty($_POST)){

            $role = $roleRepository->findOneBy(['code' => 'user']);

            $user = new User();

            $user->setFirstname(filter_input(INPUT_POST, 'firstname'));
            $user->setLastname(filter_input(INPUT_POST, 'lastname'));
            $user->setLogin(filter_input(INPUT_POST, 'login'));
            $user->setPassword(password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT));
            $user->setCreatedAt(new \DateTime());
            $user->setRole($role->getId());

            $validate = $userRepository->add($user);

            if ($validate === true){
                header('Location: http://localhost/Authentication/signIn');
            }
            else{
                var_dump($validate);
            }
        }

        $form = $authenticationForm->signIn();

        $this->render('authentication/signUp', [
            'form' => $form->create()
        ]);
    }

    public function signIn(){

        $userRepository = new UserRepository();
        $authenticationForm = new AuthentificationForm();

        if (!empty($_POST)){

            $login = filter_input(INPUT_POST, 'login');
            $password = filter_input(INPUT_POST, 'password');

            $user = $userRepository->findOneBy(['login' => $login]);

            if (password_verify($password, $user->getPassword())){
                Session::set('user', $user);
                header('Location: http://localhost/');
            }
        }

        $form = $authenticationForm->signIn();

        $this->render('authentication/signIn', [
            'form' => $form->create()
        ]);
    }

    public function logout(){
        session_destroy();
            header('Location: http://localhost/');
    }
}