<?php

namespace App\Src\Service;

use App\Src\Controller\Request;
use App\Src\Controller\Session;
use App\Src\Entity\Comment as CommentEntity;
use App\Src\Repository\CommentRepository;
use App\Src\Validator\CommentValidator;

class CommentService
{


    /**
     * @param int     $idPost  parameter
     * @param Request $request parameter
     * @param Session $session parameter
     * @return void
     */
    public function addComment(int $idPost, Request $request, Session $session)
    {
        $comment = new CommentEntity("default", $idPost);

        $comment->setContent($request->get('post', 'content'));

        if ($session->getAuth('level') === 99) {
            $comment->setValidatedAt($comment->getCreatedAt());
        }

        $commentValidator = new CommentValidator($comment);

        $testComment = $commentValidator->validate();

        if ($testComment === true) {
            $commentRepository = new CommentRepository();
            $commentRepository->insert($comment);

            $session->setFlash('success', "Le commentaire a bien été envoyé");
        }

    }
    

}
