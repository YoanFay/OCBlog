<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Comment;

class CommentRepository{

    private $bdd;
    private $class = Comment::class;

    public function __construct()
    {
        $this->bdd = new BDD();
    }

    public function insert(Comment $comment)
    {

        $req = 'INSERT INTO comment VALUES(NULL, :content, :createdAt, :validatedAt, :updatedAt, :deletedAt, :post, :user)';

        $commentInfo = [
            'content' => $comment->getContent(),
            'createdAt' => $comment->getCreatedAt(),
            'validatedAt' => $comment->getValidatedAt(),
            'updatedAt' => $comment->getUpdatedAt(),
            'deletedAt' => $comment->getDeletedAt(),
            'post' => $comment->getPostId(),
            'user' => $comment->getUserId(),
        ];

        $this->bdd->query($req, $commentInfo);
    }

    public function findAll()
    {

        $req = 'SELECT * FROM comment ORDER BY created_at DESC ';

        if ($comments = $this->bdd->select($req, $this->class)) {
            return $comments;
        } else {
            return NULL;
        }

    }

    public function findBy(array $parameters = [], array $sorts = [])
    {

        $req = 'SELECT c.*, u.avatar, u.firstname, u.lastname FROM comment c INNER JOIN user u on c.user_id = u.id';

        $row = 0;
        $length = count($parameters);

        if ($parameters !== []) {
            $req .= ' WHERE ';

            foreach ($parameters as $key => $parameter) {

                switch ($parameter){
                    case "is not null":
                        $req .= "$key IS NOT NULL";
                        break;
                    case "is null":
                        $req .= "$key IS NULL";
                        break;
                    default:
                        $req .= "$key = '$parameter'";
                }

                $row++;

                if ($row !== $length) {
                    $req .= " AND ";
                }
            }
        }

        $row = 0;
        $length = count($sorts);

        if ($sorts !== []) {
            $req .= ' ORDER BY ';

            foreach ($sorts as $key => $sort) {
                $req .= "$key $sort";

                $row++;

                if ($row !== $length) {
                    $req .= ", ";
                }
            }
        }

        if ($comments = $this->bdd->select($req, $this->class)) {
            return $comments;
        } else {
            return NULL;
        }

    }

    public function find(int $id){

        $req = "SELECT * FROM comment WHERE id = ".$id;

        if($comment = $this->bdd->select($req, $this->class)) {
            return $comment[0];
        }else{
            return NULL;
        }
    }

    public function softDelete(int $id){
        $req = 'UPDATE comment SET deleted_at = "'.date_format(new \DateTime(), 'Y-m-d H:i:s').'" WHERE id = '.$id;

        try {
            $this->bdd->query($req);
        }catch (Exception $e){
            return $e;
        }
    }

    public function update(Comment $comment)
    {

        $req = 'UPDATE comment SET content = :content, validated_at = :validatedAt, updated_at = :updatedAt WHERE id = :id';

        $commentInfo = [
            'id' => $comment->getId(),
            'content' => $comment->getContent(),
            'validatedAt' => $comment->getValidatedAt(),
            'updatedAt' => date_format(new \DateTime(), 'Y-m-d H:i:s'),
        ];

        try {
            $this->bdd->query($req, $commentInfo);
        }catch (Exception $e){
            return $e;
        }
    }
}
