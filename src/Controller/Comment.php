<?php

namespace App\Src\Controller;

use App\Src\Form\CommentForm;
use App\Src\Repository\CommentRepository;
use App\Src\Repository\PostRepository;
use App\Src\Validator\CommentValidator;

class Comment extends Controller
{


    /**
     * @param int $postId parameter
     *
     * @return void
     */
    public function moderateComment(int $postId)
    {

        if ($this->session->getAuth('level') < 60) {
            $this->redirectTo('/');
        }

        $postRepository = new PostRepository();
        $commentRepository = new CommentRepository();
        $post = $postRepository->find($postId);
        $comments = $commentRepository->findBy(['post_id' => $postId, 'validated_at' => "is null", 'deleted_at' => "is null"], ['created_at' => 'DESC']);

        $this->render(
            'comment/moderateComment',
            [
                "post" => $post,
                "comments" => $comments
            ]
        );

    }//end moderateComment()


    /**
     * Page de confirmation pour supprimer un commentaire
     *
     * @param int $idComment parameter
     *
     * @return void
     */
    public function deleteComment(int $idComment)
    {
        $user = $this->session->getAuth();
        if ($user === FALSE) {
            $this->redirectTo('/');
        }

        $request = new Request();
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($idComment);

        if ($this->valideForm($request, 'deleteComment', 'Comment/deleteComment/'.$idComment) === TRUE) {
            $commentRepository->softDelete($idComment);

            $this->session->setFlash('success', 'Le commentaire à bien était supprimé');

            $this->redirectTo('/Post/OnePost/'.$comment->getPostId());

        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $commentForm->deleteComment($idComment, $token, $comment->getPostId());

        $this->render(
            'comment/delete',
            [
                'form' => $form->create(),
                'comment' => $comment
            ]
        );

    }

    /**
     * Page de confirmation pour publier un commentaire
     *
     * @param int $idComment parameter
     *
     * @return void
     */
    public function publishedComment(int $idComment)
    {
        if ($this->session->getAuth() === FALSE) {
            $this->redirectTo('/');
        }

        $request = new Request();
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($idComment);

        if ($this->valideForm($request, 'publishComment', 'Comment/publishedComment/'.$idComment) === TRUE) {
            $comment->setValidatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $commentRepository->update($comment);

            $this->session->setFlash('success', "L'article a bien été publié");

            $this->redirectTo('/');

        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $commentForm->publishComment($idComment, $token, $comment->getPostId());

        $this->render(
            'comment/publish',
            [
                'form' => $form->create(),
                'comment' => $comment
            ]
        );

    }

    /**
     * Formulaire pour modifier un commentaire
     *
     * @param int $idComment parameter
     *
     * @return void
     */
    public function updateComment(int $idComment)
    {
        $user = $this->session->getAuth();
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($idComment);
        if ($user === FALSE || $user['user_id'] !== $comment->getUserId()) {
            $this->redirectTo('/');
        }

        $request = new Request();

        $testComment = [];

        if ($this->valideForm($request, 'updateComment', 'Comment/updateComment/'.$idComment) === TRUE) {
            $comment->setContent($request->get('post', 'content'));
            $comment->setUpdatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $comment->setValidatedAt(Null);

            if ($this->session->getAuth('level') === 99) {
                $comment->setValidatedAt($comment->getUpdatedAt());
            }

            $commentValidator = new CommentValidator($comment);

            $testComment = $commentValidator->validate();

            if ($testComment === true) {
                $commentRepository->update($comment);

                $this->session->setFlash('success', 'Le commentaire à bien était modifié');
                $this->redirectTo('/');
            }//end if

        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        $this->session->setToken($token);

        $form = $commentForm->updateComment($testComment, $idComment, $comment->getContent(), $token, $comment->getPostId());

        $this->render(
            'comment/update',
            [
                'form' => $form->create(),
            ]
        );
    }

}
