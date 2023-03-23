<?php

namespace App\Src\Controller;

use App\Src\Form\CommentForm;
use App\Src\Repository\CommentRepository;
use App\Src\Repository\PostRepository;
use App\Src\Validator\CommentValidator;

class Comment extends Controller
{

    /**
     * Affichage des commentaires à modérer
     *
     * @return void
     */
    public function moderateComment($postId)
    {

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $postRepository = new PostRepository();
        $commentRepository = new CommentRepository();
        $post = $postRepository->find($postId);
        $comments = $commentRepository->findBy(['post_id' => $postId, 'validated_at' => "is null", 'deleted_at' => "is null"], ['created_at' => 'DESC']);

        $this->render('comment/moderateComment', [
            "post" => $post,
            "comments" => $comments
        ]);
    }

    /**
     * Page de confirmation pour supprimer un commentaire
     *
     * @return void
     */
    public function deleteComment($id)
    {
        $user = Session::getAuth();
        if (!$user) {
            header('Location: /');
        }

        $request = new Request();
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($id);

        if ($this->valideForm($request, 'deleteComment', 'Comment/deleteComment/' . $id)) {

            $commentRepository->softDelete($id);

            Session::setFlash('success', 'Le commentaire à bien était supprimé');

            header('Location: /Post/OnePost/' . $comment->getPostId());

        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $commentForm->deleteComment($id, $token, $comment->getPostId());

        $this->render('comment/delete', [
            'form' => $form->create(),
            'comment' => $comment
        ]);
    }

    /**
     * Page de confirmation pour publier un commentaire
     *
     * @return void
     */
    public function publishedComment($id)
    {
        if (!Session::getAuth()) {
            header('Location: /');
        }

        $request = new Request();
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($id);

        if ($this->valideForm($request, 'publishComment', 'Comment/publishedComment/' . $id)) {

            $comment->setValidatedAt(date_format(new \DateTime(), 'Y-m-d H:i:s'));
            $commentRepository->update($comment);

            Session::setFlash('success', "L'article a bien été publié");

            header('Location: /');

        }

        $commentForm = new CommentForm();

        $token = uniqid(rand(), true);

        Session::setToken($token);

        $form = $commentForm->publishComment($id, $token, $comment->getPostId());

        $this->render('comment/publish', [
            'form' => $form->create(),
            'comment' => $comment
        ]);

    }

    /**
     * Formulaire pour modifier un commentaire
     *
     * @return void
     */
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

        $form = $commentForm->updateComment($testComment, $id, $comment->getContent(), $token, $comment->getPostId());

        $this->render('comment/update', [
            'form' => $form->create(),
        ]);
    }

}