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
        $request = new Request();

        if ($this->valideForm($request, 'signUp', 'Authentication/signUp')){

            $role = $roleRepository->findOneBy(['code' => 'user']);

            $user = new User();

            $user->setFirstname($request->get('post', 'firstname'));
            $user->setLastname($request->get('post', 'lastname'));
            $user->setLogin($request->get('post', 'login'));
            $user->setPassword(password_hash($request->get('post', 'password'), PASSWORD_BCRYPT));
            $user->setRoleId($role->getId());

            $validate = $userRepository->add($user);

            if ($validate === true){
                header('Location: /Authentication/signIn');
            }
            else{
                var_dump($validate);
            }
        }

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $authenticationForm->signUp($token);

        $this->render('authentication/signUp', [
            'form' => $form->create()
        ]);
    }

    public function signIn(){

        $userRepository = new UserRepository();
        $roleRepository = new RoleRepository();
        $authenticationForm = new AuthentificationForm();
        $request = new Request();

        if ($this->valideForm($request, 'signIn', 'Authentication/signIn')){

            $login = $request->get('post', 'login');
            $password = $request->get('post', 'password');

            $user = $userRepository->findOneBy(['login' => $login]);
            $role = $roleRepository->find($user->getRoleId());

            if (password_verify($password, $user->getPassword())){
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

    public function logout(){
        Session::logout();
        header('Location: /');
    }
}