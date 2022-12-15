<?php

namespace App\Src\Controller;

use App\Src\Core\Bdd;
use App\Src\Core\Form;
use App\Src\Form\PostForm;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\PostRepository;
use App\Src\Repository\RoleRepository;
use App\Src\Validator\PostValidator;
use Twig\Cache\NullCache;
use App\Src\Entity\Post AS PostEntity;

class Post extends Controller {

    public function index(){
        header('Location: http://localhost/Post/add');
    }

    public function add(){

        $categoryRepository = new CategoryRepository();
        $roleRepository = new RoleRepository();
        $postRepository = new PostRepository();
        $postForm = new PostForm();
        $testPost = [];
        $user = Session::get('user');

        if ($user === NULL){
            header('Location: http://localhost');
        }

        if (!empty($_POST)){

            $createdAt = date_format(new \DateTime(), 'Y-m-d H:i:s');
            $publishedAt = NULL;

            $rolesCheck = $roleRepository->findOneBy(['id' => $user->getRoleId()]);


            if ($rolesCheck->getCode() === 'superAdmin'){
                $publishedAt = $createdAt;
            }
            //Fonction temporaire
            else{
                header('Location: http://localhost');
            }

            $post = new PostEntity();

            $post->setContent(filter_input(INPUT_POST, 'content'));
            $post->setImage(NULL);
            $post->setCreatedAt($createdAt);
            $post->setPublishedAt($publishedAt);
            $post->setUpdatedAt(NULL);
            $post->setDeletedAt(NULL);
            $post->setExcerpt(substr(filter_input(INPUT_POST, 'content'), 0, 70));
            $post->setCategoryId(filter_input(INPUT_POST, 'category'));
            $post->setUserId($user->getId());

            $postValidator = new PostValidator($post);

            $testPost = $postValidator->validate();

            if ($testPost === true) {
                $postRepository->insert($post);

                header('Location: http://localhost');
            }
        }

        $categories = $categoryRepository->findAll();

        $categoryTab = [];

        foreach ($categories as $category) {
            $categoryTab += [
                $category->getId() => $category->getName(),
            ];
        }

        $form = $postForm->addPost($categoryTab, $testPost);

        $this->render('post/add', [
            'form' => $form->create()
        ]);

    }
}