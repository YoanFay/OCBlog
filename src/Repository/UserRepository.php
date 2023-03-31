<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\User;
use Exception;

class UserRepository
{

    private $bdd;
    private $class = User::class;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->bdd = new BDD();
    }

    /**
     * @param User $user parameter
     * @return bool|Exception
     */
    public function add(User $user)
    {

        $infoUser = [
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'created' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            'role' => $user->getRoleId(),
            'avatar' => $user->getAvatar()
        ];

        $req = 'INSERT INTO user VALUES(NULL, :lastname, :firstname, :login, :password, :created, :avatar, :role)';

        try {
            $this->bdd->query($req, $infoUser);
            return true;
        } catch (Exception $e) {
            return $e;
        }

    }

    /**
     * @param array $parameters parameter
     * @return mixed|null
     */
    public function findOneBy(array $parameters = [])
    {

        $req = 'SELECT * FROM user';

        $row = 0;
        $length = count($parameters);

        if ($parameters !== []) {
            $req .= ' WHERE ';

            foreach ($parameters as $key => $parameter) {
                $req .= "$key = '$parameter'";

                $row++;

                if ($row !== $length) {
                    $req .= " AND ";
                }
            }
        }

        if ($user = $this->bdd->select($req, $this->class)) {
            return $user[0];
        }

        return NULL;

    }

    /**
     * @param int $idUser parameter
     * @return mixed|null
     */
    public function find(int $idUser)
    {

        $req = 'SELECT * FROM user WHERE id = '.$idUser;

        if ($user = $this->bdd->select($req, $this->class)) {
            return $user[0];
        }

        return NULL;

    }

}
