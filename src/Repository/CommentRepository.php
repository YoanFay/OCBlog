<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Comment;
use Exception;

class CommentRepository
{

    /**
     * @var Bdd
     */
    private $bdd;

    /**
     * @var string
     */
    private $class = Comment::class;


    /**
     * Constructeur
     */
    public function __construct()
    {

        $this->bdd = new BDD();

    }//end __construct()


    /**
     * @param Comment $comment parameter
     *
     * @return void
     */
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


    /**
     * @return array|null
     */
    public function findAll()
    {

        $req = 'SELECT * FROM comment ORDER BY created_at DESC ';

        if ($comments = $this->bdd->select($req, $this->class)) {
            return $comments;
        }

        return NULL;

    }


    /**
     * @param array $parameters parameter
     * @param array $sorts      parameter
     *
     * @return array|null
     */
    public function findBy(array $parameters = [], array $sorts = [])
    {

        $req = 'SELECT c.*, u.avatar, u.firstname, u.lastname, u.avatar FROM comment c INNER JOIN user u on c.user_id = u.id';

        if (empty($parameters) === FALSE) {
            $req .= ' WHERE ';
            $clauses = [];
            foreach ($parameters as $key => $parameter) {
                switch ($parameter) {
                case "is not null":
                    $clauses[] = "$key IS NOT NULL";
                    break;
                case "is null":
                    $clauses[] = "$key IS NULL";
                    break;
                default:
                    $clauses[] = "$key = '$parameter'";
                }
            }
            $req .= implode(" AND ", $clauses);
        }

        if (empty($sorts) === FALSE) {
            $req .= ' ORDER BY ';
            $clauses = [];
            foreach ($sorts as $key => $sort) {
                $clauses[] = "$key $sort";
            }
            $req .= implode(", ", $clauses);
        }

        return $this->bdd->select($req, $this->class);

    }


    /**
     * @param int $idComment parameter
     *
     * @return mixed|null
     */
    public function find(int $idComment)
    {

        $req = "SELECT * FROM comment WHERE id = ".$idComment;

        if ($comment = $this->bdd->select($req, $this->class)) {
            return $comment[0];
        }

        return NULL;

    }


    /**
     * @param int $idComment parameter
     *
     * @return Exception|void
     */
    public function softDelete(int $idComment)
    {

        $req = 'UPDATE comment SET deleted_at = "'.date_format(new \DateTime(), 'Y-m-d H:i:s').'" WHERE id = '.$idComment;

        try {
            $this->bdd->query($req);
        } catch (Exception $e) {
            return $e;
        }
    }


    /**
     * @param Comment $comment parameter
     *
     * @return Exception|void
     */
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
        } catch (Exception $e) {
            return $e;
        }
    }
}
