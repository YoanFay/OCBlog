<?php

namespace App\Src\Service;

use App\Src\Controller\Request;
use App\Src\Controller\Session;
use App\Src\Entity\File;
use App\Src\Entity\Post;
use App\Src\Repository\PostRepository;
use App\Src\Validator\FileValidator;
use App\Src\Validator\PostValidator;

class PostService
{


    /**
     * @param Request $request parameter
     * @param Session $session parameter
     * @return bool
     */
    public function addPost(Request $request, Session $session): bool
    {
        $post = new Post("default");

        $post->setContent($request->get('post', 'content'));
        $post->setCategoryId($request->get('post', 'category'));

        if ($session->getAuth('level') === 99) {
            $post->setPublishedAt($post->getCreatedAt());
        }

        $postValidator = new PostValidator($post);

        $testPost = $postValidator->validate();

        $file = new File($request->get('file', 'image'));

        $fileValidator = new FileValidator($file);

        $testFile = $fileValidator->validateImage();

        if ($testPost === true && $testFile === true) {
            if ($file->getName()) {
                $uploadService = new UploadService();
                if ($filename = $uploadService->uploadPost($file)) {
                    $post->setImage($filename);
                } else {
                    $session->setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                }
            }

            $postRepository = new PostRepository();
            $postRepository->insert($post);

            $session->setFlash('success', "L'article a bien été envoyé");

            return true;
        }

        return false;

    }

    /**
     * @param Post           $post           parameter
     * @param Request        $request        parameter
     * @param Session        $session        parameter
     * @param PostRepository $postRepository parameter
     * @return bool
     */
    public function updatePost(Post $post, Request $request, Session $session, PostRepository $postRepository): bool
    {
        $post->setContent($request->get('post', 'content'));
        $post->setExcerpt(substr($request->get('post', 'content'), 0, 70));
        $post->setCategoryId($request->get('post', 'category'));
        $post->setUpdatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));

        if ($session->getAuth('level') === 99) {
            $post->setPublishedAt($post->getUpdatedAt());
        } else {
            $post->setPublishedAt(Null);
        }

        $testImage = 'noChange';
        $image = false;
        if ($request->get('file', 'image')['size'] > 0) {
            $image = new File($request->get('file', 'image'));
            $fileValidator = new FileValidator($image);
            $testImage = $fileValidator->validateImage();
        }

        $testPost = (new PostValidator($post))->validate();

        if ($image !== false & $testPost === true && ($testImage === true || $testImage === 'noChange')) {
            $uploadService = new UploadService();

            if ($testImage !== 'noChange' && $image->getName() && $filename = $uploadService->uploadConfigImage($image)) {
                $post->setImage($filename);
            } else if ($testImage !== 'noChange') {
                $session->setFlash('danger', "Un problème est survenue lors du transfert de l'image");
            }
        }

        if ($postRepository->update($post)) {

            $session->setFlash('success', "L'article à bien était modifié");
            return true;
        }

        return false;
    }
}
