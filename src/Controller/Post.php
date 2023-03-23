<?php

namespace App\Src\Controller;

use App\Src\Entity\Comment as CommentEntity;
use App\Src\Entity\File;
use App\Src\Form\CommentForm;
use App\Src\Form\PostForm;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\CommentRepository;
use App\Src\Repository\PostRepository;
use App\Src\Service\UploadService;
use App\Src\Validator\CommentValidator;
use App\Src\Validator\FileValidator;
use App\Src\Validator\PostValidator;
use App\Src\Entity\Post as PostEntity;

class Post extends Controller
{

    public function index()
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        $this->render('post/index', [
            "categories" => $categories,
            "user" => Session::getAuth(),
        ]);
    }

    public function onePost($id)
    {
        $testComment = [];

        $request = new Request();

        if ($this->valideForm($request, 'addComment', 'Post/onePost/' . $id)) {

            $comment = new CommentEntity("default", $id);

            $comment->setContent($request->get('post', 'content'));

            if (Session::getAuth('level') === 99) {
                $comment->setValidatedAt($comment->getCreatedAt());
            }

            $commentValidator = new CommentValidator($comment);

            $testComment = $commentValidator->validate();

            if ($testComment === true) {
                $commentRepository = new CommentRepository();
                $commentRepository->insert($comment);

                Session::setFlash('success', "Le commentaire a bien été envoyé");
            }
        }

        $postRepository = new PostRepository();
        $commentRepository = new CommentRepository();
        $post = $postRepository->find($id);

        $comments = $commentRepository->findBy(['post_id' => $post->getId(), 'validated_at' => "is not null", 'deleted_at' => 'is null'], ['created_at' => 'DESC']);

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $commentForm->addComment($id, $testComment, $token);

        $this->render('post/onePost', [
            "post" => $post,
            "comments" => $comments,
            "user" => Session::getAuth(),
            'form' => $form->create(),
        ]);
    }

    public function deletePost($id)
    {

        $user = Session::getAuth();
        if (!$user) {
            header('Location: /');
        }

        $request = new Request();
        $postRepository = new PostRepository();
        $post = $postRepository->find($id);

        if ($this->valideForm($request, 'deletePost', 'Post/deletePost/' . $id)) {


            $file = "/img/post/" . $post->getImage();
            if (file_exists($file)) {
                unlink($file);
                $post->setImage(Null);
            }

            $postRepository->softDelete($id);

            Session::setFlash('success', "L'article à bien était supprimé");

            header('Location: /');

        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $postForm->deletePost($id, $token);

        $this->render('post/delete', [
            'form' => $form->create(),
            'post' => $post
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

        if ($this->valideForm($request, 'updatePost', 'Post/updatePost/' . $id)) {

            $post->setContent($request->get('post', 'content'));
            $post->setExcerpt(substr($request->get('post', 'content'), 0, 70));
            $post->setCategoryId($request->get('post', 'category'));
            $post->setUpdatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));

            if (Session::getAuth('level') === 99) {
                $post->setPublishedAt($post->getUpdatedAt());
            } else {
                $post->setPublishedAt(Null);
            }

            if ($request->get('file', 'image')['size'] > 0) {

                $image = new File($request->get('file', 'image'));

                $fileValidator = new FileValidator($image);

                $testImage = $fileValidator->validateImage();
            } else {
                $testImage = 'noChange';
            }

            $postValidator = new PostValidator($post);

            $testPost = $postValidator->validate();

            if ($testPost === true && ($testImage === true || $testImage === 'noChange')) {

                if ($testImage !== 'noChange' && $image->getName()) {

                    if ($filename = UploadService::uploadConfigImage($image)) {
                        $post->setImage($filename);
                    } else {
                        Session::setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    }
                }

                $postRepository->update($post);

                Session::setFlash('success', "L'article à bien était modifié");
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

        $form = $postForm->updatePost($categoryTab, $testPost, $id, $post->getContent(), $token, $post->getImage());

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
        $testFile = [];

        if ($this->valideForm($request, 'addPost', 'Post/add')) {

            $post = new PostEntity("default");

            $post->setContent($request->get('post', 'content'));
            $post->setCategoryId($request->get('post', 'category'));

            if (Session::getAuth('level') === 99) {
                $post->setPublishedAt($post->getCreatedAt());
            }

            $postValidator = new PostValidator($post);

            $testPost = $postValidator->validate();

            $file = new File($request->get('file', 'image'));

            $fileValidator = new FileValidator($file);

            $testFile = $fileValidator->validateImage();

            if ($testPost === true && $testFile === true) {

                if ($file->getName()) {

                    if ($filename = UploadService::uploadPost($file)) {
                        $post->setImage($filename);
                    } else {
                        Session::setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    }
                }

                $postRepository = new PostRepository();
                $postRepository->insert($post);

                Session::setFlash('success', "L'article a bien été envoyé");

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

        $form = $postForm->addPost($categoryTab, $testPost, $testFile, $token);

        $this->render('post/add', [
            'form' => $form->create(),
        ]);

    }

    public function listPostNotValidate()
    {

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        $this->render('post/moderate', [
            "categories" => $categories,
            "user" => Session::getAuth(),
        ]);

    }

    public function publishedPost($id)
    {

        if (!Session::getAuth()) {
            header('Location: /');
        }

        $request = new Request();
        $postRepository = new PostRepository();
        $post = $postRepository->find($id);

        if ($this->valideForm($request, 'publishPost', 'Post/publishedPost/' . $id)) {
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
            'post' => $post
        ]);

    }

    public function listPostAjax()
    {
        $request = new Request();
        $postRepository = new PostRepository();
        $category_id = $request->get('post', 'category') ?? 0;


        if ($category_id == 0) {
            $posts = $postRepository->findPublishedPost();
        } else {
            $posts = $postRepository->findPublishedPostByCategory($category_id);
        }

        $this->render('post/listPostAjax', [
            "posts" => $posts,
            "user" => Session::getAuth(),
        ]);
    }

    public function listModeratePostAjax()
    {
        $request = new Request();
        $postRepository = new PostRepository();
        $category_id = $request->get('post', 'category') ?? 0;


        if ($category_id == 0) {
            $posts = $postRepository->findNotPublishedPost();
        } else {
            $posts = $postRepository->findNotPublishedPostByCategory($category_id);
        }

        $this->render('post/listModeratePostAjax', [
            "posts" => $posts,
            "user" => Session::getAuth(),
        ]);
    }

    public function listModerateCommentPostAjax()
    {
        $request = new Request();
        $postRepository = new PostRepository();
        $category_id = $request->get('post', 'category') ?? 0;

        if ($category_id == 0) {
            $posts = $postRepository->findNotPublishedCommentPost();
        } else {
            $posts = $postRepository->findNotPublishedCommentPostByCategory($category_id);
        }

        $this->render('comment/listModerateCommentPostAjax', [
            "posts" => $posts,
            "user" => Session::getAuth(),
        ]);
    }
}
