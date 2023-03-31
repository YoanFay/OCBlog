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


    /**
     * Page pour voir les articles
     *
     * @return void
     */
    public function index()
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        $this->render(
            'post/index',
            [
                "categories" => $categories,
                "user" => $this->session->getAuth(),
            ]
        );

    }

    /**
     * Page pour voir un article
     *
     * @return void
     */
    public function onePost($idPost)
    {
        $testComment = [];

        $request = new Request();

        if ($this->valideForm($request, 'addComment', 'Post/onePost/'.$idPost)) {
            $comment = new CommentEntity("default", $idPost);

            $comment->setContent($request->get('post', 'content'));

            if ($this->session->getAuth('level') === 99) {
                $comment->setValidatedAt($comment->getCreatedAt());
            }

            $commentValidator = new CommentValidator($comment);

            $testComment = $commentValidator->validate();

            if ($testComment === true) {
                $commentRepository = new CommentRepository();
                $commentRepository->insert($comment);

                $this->session->setFlash('success', "Le commentaire a bien été envoyé");
            }
            //endif
        }

        $postRepository = new PostRepository();
        $commentRepository = new CommentRepository();
        $post = $postRepository->find($idPost);

        $comments = $commentRepository->findBy(['post_id' => $post->getId(), 'validated_at' => "is not null", 'deleted_at' => 'is null'], ['created_at' => 'DESC']);

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $commentForm->addComment($idPost, $testComment, $token);

        $this->render(
            'post/onePost',
            [
                "post" => $post,
                "comments" => $comments,
                "user" => $this->session->getAuth(),
                'form' => $form->create(),
            ]
        );
    }

    /**
     * Page de confirmation pour supprimer un article
     *
     * @return void
     */
    public function deletePost($idPost)
    {

        $user = $this->session->getAuth();
        if ($user === FALSE) {
            $this->redirectTo('/');
        }

        $request = new Request();
        $postRepository = new PostRepository();
        $post = $postRepository->find($idPost);

        if ($this->valideForm($request, 'deletePost', 'Post/deletePost/'.$idPost)) {

            $file = "/img/post/".$post->getImage();
            if (file_exists($file)) {
                unlink($file);
                $post->setImage(Null);
            }

            $postRepository->softDelete($idPost);

            $this->session->setFlash('success', "L'article à bien était supprimé");

            $this->redirectTo('/');

        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $postForm->deletePost($idPost, $token);

        $this->render(
            'post/delete',
            [
                'form' => $form->create(),
                'post' => $post
            ]
        );
    }

    /**
     * Formulaire pour modifier un article
     *
     * @return void
     */
    public function updatePost($idPost)
    {
        $user = $this->session->getAuth();
        $postRepository = new PostRepository();
        $post = $postRepository->find($idPost);
        if ($user === FALSE || $user['user_id'] !== $post->getUserId()) {
            $this->redirectTo('/');
        }

        $request = new Request();

        $testPost = [];

        if ($this->valideForm($request, 'updatePost', 'Post/updatePost/'.$idPost)) {

            $post->setContent($request->get('post', 'content'))
                ->setExcerpt(substr($request->get('post', 'content'), 0, 70))
                ->setCategoryId($request->get('post', 'category'))
                ->setUpdatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));

            if ($this->session->getAuth('level') === 99) {
                $post->setPublishedAt($post->getUpdatedAt());
            } else {
                $post->setPublishedAt(Null);
            }

            $testImage = 'noChange';
            if ($request->get('file', 'image')['size'] > 0) {
                $image = new File($request->get('file', 'image'));
                $fileValidator = new FileValidator($image);
                $testImage = $fileValidator->validateImage();
            }

            $testPost = (new PostValidator($post))->validate();

            if ($testPost === true && ($testImage === true || $testImage === 'noChange')) {

                if ($testImage !== 'noChange' && $image->getName() && $filename = UploadService::uploadConfigImage($image)) {
                    $post->setImage($filename);
                } else if ($testImage !== 'noChange') {
                    $this->session->setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                }
            }

            $postRepository->update($post);

            $this->session->setFlash('success', "L'article à bien était modifié");
            $this->redirectTo('/');
        }

        $categoryTab = [];
        foreach ((new CategoryRepository())->findAll() as $category) {
            $categoryTab[$category->getId()] = $category->getName();
        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $postForm->updatePost($categoryTab, $testPost, $idPost, $post->getContent(), $token, $post->getImage());

        $this->render(
            'post/update',
            [
                'form' => $form->create(),
            ]
        );
    }

    /**
     * Formulaire pour ajouter un article
     *
     * @return void
     */
    public function add()
    {
        $user = $this->session->getAuth();
        if (!$user) {
            $this->redirectTo('/');
        }

        $request = new Request();
        $testPost = [];
        $testFile = [];

        if ($this->valideForm($request, 'addPost', 'Post/add')) {
            $post = new PostEntity("default");

            $post->setContent($request->get('post', 'content'));
            $post->setCategoryId($request->get('post', 'category'));

            if ($this->session->getAuth('level') === 99) {
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
                        $this->session->setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    }
                }

                $postRepository = new PostRepository();
                $postRepository->insert($post);

                $this->session->setFlash('success', "L'article a bien été envoyé");

                $this->redirectTo('/');
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

        $this->session->setToken($token);

        $form = $postForm->addPost($categoryTab, $testPost, $testFile, $token);

        $this->render(
            'post/add',
            [
                'form' => $form->create(),
            ]
        );

    }

    /**
     * Page pour voir les articles non publiés
     *
     * @return void
     */
    public function listPostNotValidate()
    {

        if ($this->session->getAuth('level') < 60) {
            $this->redirectTo('/');
        }

        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        $this->render(
            'post/moderate',
            [
                "categories" => $categories,
                "user" => $this->session->getAuth(),
            ]
        );

    }

    /**
     * Page de confirmation pour publier un article
     *
     * @return void
     */
    public function publishedPost($idPost)
    {

        if ($this->session->getAuth() === FALSE) {
            $this->redirectTo('/');
        }

        $request = new Request();
        $postRepository = new PostRepository();
        $post = $postRepository->find($idPost);

        if ($this->valideForm($request, 'publishPost', 'Post/publishedPost/'.$idPost)) {
            $post->setPublishedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $postRepository->update($post);

            $this->session->setFlash('success', "L'article a bien été publié");

            $this->redirectTo('/');

        }

        $postForm = new PostForm();

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $postForm->publishPost($idPost, $token);

        $this->render(
            'post/publish',
            [
                'form' => $form->create(),
                'post' => $post
            ]
        );

    }

    /**
     * Fonction pour sélectionner les articles publiés selon leur catégorie
     *
     * @return void
     */
    public function listPostAjax()
    {
        $request = new Request();
        $postRepository = new PostRepository();
        $category_id = ($request->get('post', 'category') ?? 0);


        if ($category_id == 0) {
            $posts = $postRepository->findPublishedPost();
        } else {
            $posts = $postRepository->findPublishedPostByCategory($category_id);
        }

        $this->render(
            'post/listPostAjax',
            [
                "posts" => $posts,
                "user" => $this->session->getAuth(),
            ]
        );
    }

    /**
     * Fonction pour sélectionner les articles non publiés selon leur catégorie
     *
     * @return void
     */
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

        $this->render(
            'post/listModeratePostAjax',
            [
                "posts" => $posts,
                "user" => $this->session->getAuth(),
            ]
        );
    }

    /**
     * Fonction pour sélectionner les commentaires non publiés par articles selon leur catégorie
     *
     * @return void
     */
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

        $this->render(
        'comment/listModerateCommentPostAjax',
            [
                "posts" => $posts,
                "user" => $this->session->getAuth(),
            ]
        );
    }
}
