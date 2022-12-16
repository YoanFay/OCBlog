<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Role;
use Exception;

class RoleRepository{

    private $bdd;
    private $class = Role::class;

    public function __construct(){
        $this->bdd = new BDD();
    }

    public function findOneBy(array $parameters = []){

        $req = 'SELECT * FROM role';

        $row = 0;
        $length = count($parameters);

        if ($parameters !== []){
            $req .= ' WHERE ';

            foreach($parameters as $key => $parameter){
                $req .= "$key = '$parameter'";

                $row++;

                if ($row !== $length){
                    $req .= " AND ";
                }
            }
        }

        if($role = $this->bdd->select($req, $this->class)) {
            return $role[0];
        }else{
            return NULL;
        }

    }

    public function find(int $id){

        $req = "SELECT * FROM role WHERE id = ".$id;

        if($role = $this->bdd->select($req, $this->class)) {
            return $role[0];
        }else{
            return NULL;
        }
    }

}
