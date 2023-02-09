<?php

namespace App\Src\Controller;

use App\Src\Form\CommentForm;
use App\Src\Repository\CommentRepository;
use App\Src\Repository\PostRepository;
use App\Src\Validator\CommentValidator;

class Comment extends Controller {

    public function listModerateCommentAjax($postId)
    {
        $commentRepository = new CommentRepository();

        $commments = $commentRepository->findNotPublishedComment($postId);

        $this->render('post/listModerateCommente', [
            //"post" => $post,
            "commments" => $commments,
            "user" => Session::getAuth(),
        ]);
    }

    public function moderateComment($postId){

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $postRepository = new PostRepository();
        $commentRepository = new CommentRepository();
        $post = $postRepository->find($postId);
        $comments = $commentRepository->findBy(['post_id' => $post->getId(), 'validated_at' => "is null", 'deleted_at' => "is null"], ['created_at' => 'DESC']);

        $this->render('comment/moderateComment', [
            "post" => $post,
            "comments" => $comments
        ]);
    }

    public function deleteComment($id)
    {
        $user = Session::getAuth();
        if (!$user) {
            header('Location: /');
        }

        $request = new Request();

        if ($this->valideForm($request, 'deleteComment', 'Comment/deleteComment/' . $id)) {

            $commentRepository = new CommentRepository();
            $comment = $commentRepository->find($id);

            $commentRepository->softDelete($id);

            Session::setFlash('success', 'Le commentaire à bien était supprimé');

            header('Location: /Post/OnePost/'.$comment->getPostId());

        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $commentForm->deleteComment($id, $token);

        $this->render('comment/delete', [
            'form' => $form->create(),
        ]);
    }

    public function publishedComment($id)
    {
        if (!Session::getAuth()) {
            header('Location: /');
        }

        $request = new Request();

        if ($this->valideForm($request, 'publishComment', 'Comment/publishedComment/' . $id)) {

            $commentRepository = new CommentRepository();

            $comment = $commentRepository->find($id);
            $comment->setValidatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $commentRepository->update($comment);

            Session::setFlash('success', "L'article a bien été publié");

            header('Location: /');

        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $commentForm->publishComment($id, $token);

        $this->render('comment/publish', [
            'form' => $form->create(),
        ]);

    }

    public function updateComment($id)
    {
        $user = Session::getAuth();
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($id);
        if (!$user || $user['user_id'] !== $comment->getUserId()) {
            header('Location: /');
        }

        $request = new Request();

        $testComment = [];

        if ($this->valideForm($request, 'updateComment', 'Comment/updateComment/' . $id)) {

            $comment->setContent($request->get('post', 'content'));
            $comment->setUpdatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));

            if (Session::getAuth('level') === 99) {
                $comment->setValidatedAt($comment->getUpdatedAt());
            } else {
                $comment->setValidatedAt(Null);
            }

            $commentValidator = new CommentValidator($comment);

            $testComment = $commentValidator->validate();

            if ($testComment === true) {

                $commentRepository->update($comment);

                Session::setFlash('success', 'Le commentaire à bien était modifié');
                header('Location: /');
            }
        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $commentForm->updateComment($testComment, $id, $comment->getContent(), $token);

        $this->render('comment/update', [
            'form' => $form->create(),
        ]);
    }
    
}