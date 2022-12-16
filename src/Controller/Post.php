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
        $post = $postRepository->find($id[0]);

        $this->render('post/onePost', [
            "post" => $post,
            "user" => Session::getAuth(),
        ]);
    }

    public function deletePost($id)
    {

        $user = Session::getAuth();
        if ($user === NULL) {
            header('Location: /');
        }

        $request = new Request();

        if ($request->issetPost() && $request->get('post', 'formName') === 'deletePost' && $request->get('post', 'csrfToken') === Session::getToken() && $request->get('server', 'HTTP_REFERER') === 'http://localhost/Post/deletePost/' . $id[0]) {

            $postRepository = new PostRepository();
            $postRepository->delete($id[0]);

            Session::setFlash('success', 'L\'article à bien était supprimé');

            header('Location: /');

        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $postForm->deletePost($token, $id[0]);

        $this->render('post/delete', [
            'form' => $form->create(),
            'user' => $user,
        ]);

    }

    public function updatePost($id)
    {

        $user = Session::getAuth();
        $postRepository = new PostRepository();
        $post = $postRepository->find($id[0]);
        if ($user === NULL || $user['user_id'] !== $post->getUserId()) {
            header('Location: /');
        }

        $request = new Request();

        $testPost = [];

        if ($request->issetPost() && $request->get('post', 'formName') === 'updatePost' && $request->get('post', 'csrfToken') === Session::getToken() && $request->get('server', 'HTTP_REFERER') === 'http://localhost/Post/updatePost/' . $id[0]) {

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

        $form = $postForm->updatePost($categoryTab, $testPost, $id[0], $post->getContent(), $token);

        $this->render('post/update', [
            'form' => $form->create(),
            'user' => $user,
        ]);
    }

    public function add()
    {

        $user = Session::getAuth();
        if ($user === NULL) {
            header('Location: /');
        }
        $request = new Request();
        $testPost = [];

        if ($request->issetPost() && $request->get('post', 'formName') === 'addPost' && $request->get('post', 'csrfToken') === Session::getToken() && $request->get('server', 'HTTP_REFERER') === 'http://localhost/Post/add') {

            // Todo Fonctionalité temporaire
            if (Session::getAuth('level') !== 99) {
                header('Location: /');
            }

            $post = new PostEntity();

            $post->setContent($request->get('post', 'content'));
            $post->setExcerpt(substr($request->get('post', 'content'), 0, 70));
            $post->setCategoryId($request->get('post', 'category'));

            $postValidator = new PostValidator($post);

            $testPost = $postValidator->validate();

            if ($testPost === true) {
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
            'form' => $form->create()
        ]);

    }
}