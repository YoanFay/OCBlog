<?php

namespace App\Src\Controller;

use App\Src\Form\PostForm;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\PostRepository;
use App\Src\Validator\PostValidator;
use App\Src\Entity\Post as PostEntity;

class Post extends Controller
{

    public function index()
    {
        $postRepository = new PostRepository();
        $posts = $postRepository->findAll();

        $this->render('post/index', [
            "posts" => $posts,
            "user" => Session::getAuth(),
        ]);
    }

    public function onePost($id)
    {
        $postRepository = new PostRepository();
        $post = $postRepository->find($id);

        $this->render('post/onePost', [
            "post" => $post,
            "user" => Session::getAuth(),
        ]);
    }

    public function deletePost($id)
    {

        $user = Session::getAuth();
        if (!$user) {
            header('Location: /');
        }

        $request = new Request();

        if ($this->valideForm($request,'deletePost', 'Post/deletePost/' . $id)) {

            $postRepository = new PostRepository();
            $postRepository->delete($id);

            Session::setFlash('success', 'L\'article à bien était supprimé');

            header('Location: /');

        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $postForm->deletePost($id, $token);

        $this->render('post/delete', [
            'form' => $form->create(),
        ]);

    }

    public function updatePost($id)
    {

        $user = Session::getAuth();
        $postRepository = new PostRepository();
        $post = $postRepository->find($id);
        if (!$user || $user['user_id'] !== $post->getUserId()) {
            header('Location: /');
        }

        $request = new Request();

        $testPost = [];

        if ($this->valideForm($request,'updatePost', 'Post/updatePost/' . $id)) {

            // TODO Fonctionalité temporaire
            if (Session::getAuth('level') !== 99) {
                header('Location: /');
            }

            $post->setContent($request->get('post', 'content'));
            $post->setExcerpt(substr($request->get('post', 'content'), 0, 70));
            $post->setCategoryId($request->get('post', 'category'));
            $post->setUpdatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $post->setPublishedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));

            $postValidator = new PostValidator($post);

            $testPost = $postValidator->validate();

            if ($testPost === true) {
                $postRepository->insert($post);

                Session::setFlash('success', 'L\'aticle à bien était modifié');

                header('Location: /');
            }
        }

        $categoryRepository = new CategoryRepository();

        $categories = $categoryRepository->findAll();

        $categoryTab = [];

        foreach ($categories as $category) {
            $categoryTab += [
                $category->getId() => $category->getName(),
            ];
        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $postForm->updatePost($categoryTab, $testPost, $id, $post->getContent(), $token);

        $this->render('post/update', [
            'form' => $form->create(),
        ]);
    }

    public function add()
    {

        $user = Session::getAuth();
        if (!$user) {
            header('Location: /');
        }
        $request = new Request();
        $testPost = [];

        if ($this->valideForm($request, 'addPost', 'Post/add')) {

            $post = new PostEntity();

            $post->setContent($request->get('post', 'content'));
            $post->setExcerpt(substr($request->get('post', 'content'), 0, 70));
            $post->setCategoryId($request->get('post', 'category'));

            if (Session::getAuth('level') === 99) {
                $post->setPublishedAt($post->getCreatedAt());
            }

            $postValidator = new PostValidator($post);

            $testPost = $postValidator->validate();

            if ($testPost === true) {
                var_dump($post);
                $postRepository = new PostRepository();
                $postRepository->insert($post);

                Session::setFlash('success', 'L\'aticle à bien était envoyé');

                header('Location: /');
            }
        }

        $categoryRepository = new CategoryRepository();
        $postForm = new PostForm();

        $categories = $categoryRepository->findAll();

        $categoryTab = [];

        foreach ($categories as $category) {
            $categoryTab += [
                $category->getId() => $category->getName(),
            ];
        }

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $postForm->addPost($categoryTab, $testPost, $token);

        $this->render('post/add', [
            'form' => $form->create(),
        ]);

    }

    public function listPostNotValidate(){

        $postRepository = new PostRepository();
        $posts = $postRepository->findNotPublishedPost();

        $this->render('post/moderate', [
            "posts" => $posts,
            "user" => Session::getAuth(),
        ]);

    }

    public function publishedPost($id){

        if (!Session::getAuth()) {
            header('Location: /');
        }

        $request = new Request();

        if ($this->valideForm($request, 'publishPost', 'publishedPost/' . $id)) {

            $postRepository = new PostRepository();

            $post = $postRepository->find($id);
            $post->setPublishedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $postRepository->update($post);

            Session::setFlash('success', "L'article a bien été publié");

            header('Location: /');

        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $postForm->publishPost($id, $token);

        $this->render('post/publish', [
            'form' => $form->create(),
        ]);

    }
}
