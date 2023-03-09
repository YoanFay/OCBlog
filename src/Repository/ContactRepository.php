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

        $req = 'INSERT INTO contact VALUES (null, :name, :mail, :message, :createdAt, null, null, null)';

        $postInfo = [
            'name' => $contact->getName(),
            'mail' => $contact->getMail(),
            'message' => $contact->getMessage(),
            'createdAt' => $contact->getCreatedAt(),
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
}
