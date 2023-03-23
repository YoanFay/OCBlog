<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Contact;

class ContactRepository
{

    private $bdd;
    private $class = Contact::class;

    public function __construct()
    {
        $this->bdd = new Bdd();
    }

    public function insert(Contact $contact)
    {

        $req = 'INSERT INTO contact VALUES (null, :name, :mail, :message, :createdAt, null, null, null, null)';

        $postInfo = [
            'name' => $contact->getName(),
            'mail' => $contact->getMail(),
            'message' => $contact->getMessage(),
            'createdAt' => $contact->getCreatedAt(),
        ];

        $this->bdd->query($req, $postInfo);
    }

    public function update(Contact $contact)
    {
        $req = 'UPDATE contact SET name = :name, mail = :mail, message = :message, created_at = :createdAt, process = :process, process_by = :processBy, process_at = :processAt, answer = :answer WHERE id = :id';

        $postInfo = [
            'id' => $contact->getId(),
            'name' => $contact->getName(),
            'mail' => $contact->getMail(),
            'message' => $contact->getMessage(),
            'createdAt' => $contact->getCreatedAt(),
            'process' => $contact->getProcess(),
            'processBy' => $contact->getProcessBy(),
            'processAt' => $contact->getProcessAt(),
            'answer' => $contact->getAnswer(),
        ];

        $this->bdd->query($req, $postInfo);
    }

    public function findAll()
    {

        $req = 'SELECT * FROM contact';

        if ($contacts = $this->bdd->select($req, $this->class)) {
            return $contacts;
        } else {
            return NULL;
        }

    }

    public function findNotProcess()
    {

        $req = 'SELECT * FROM contact WHERE process IS NULL';

        if ($contacts = $this->bdd->select($req, $this->class)) {
            return $contacts;
        } else {
            return NULL;
        }

    }

    public function findAnswer()
    {

        $req = 'SELECT c.*, CONCAT(u.firstname, " ", u.lastname) AS user FROM contact c INNER JOIN user u on c.process_by = u.id WHERE process = "answer"';

        if ($contacts = $this->bdd->select($req, $this->class)) {
            return $contacts;
        } else {
            return NULL;
        }

    }

    public function findArchive()
    {

        $req = 'SELECT c.*, CONCAT(u.firstname, " ", u.lastname) AS user FROM contact c INNER JOIN user u on c.process_by = u.id WHERE process = "archived"';

        if ($contacts = $this->bdd->select($req, $this->class)) {
            return $contacts;
        } else {
            return NULL;
        }

    }

    public function find($id)
    {

        $req = 'SELECT * FROM contact WHERE id = ' . $id;

        if ($contact = $this->bdd->select($req, $this->class)) {
            return $contact[0];
        } else {
            return NULL;
        }

    }
}
