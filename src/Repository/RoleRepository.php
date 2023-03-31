<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Role;
use Exception;

class RoleRepository
{

    /**
     * @var Bdd
     */
    private $bdd;

    /**
     * @var string
     */
    private $class = Role::class;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->bdd = new BDD();
    }

    /**
     * @param array $parameters parameter
     * @return mixed|null
     */
    public function findOneBy(array $parameters = [])
    {

        $req = 'SELECT * FROM role';

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

        if ($role = $this->bdd->select($req, $this->class)) {
            return $role[0];
        }

        return NULL;

    }

    /**
     * @param int $idRole parameter
     * @return mixed|null
     */
    public function find(int $idRole)
    {

        $req = "SELECT * FROM role WHERE id = ".$idRole;

        if ($role = $this->bdd->select($req, $this->class)) {
            return $role[0];
        }

        return NULL;

    }

}
