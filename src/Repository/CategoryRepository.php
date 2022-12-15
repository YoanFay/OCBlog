<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Category;
use App\Src\Entity\Role;
use Exception;

class CategoryRepository{

    private $bdd;
    private $class = Category::class;

    public function __construct(){
        $this->bdd = new BDD();
    }

    public function findOneBy(array $parameters = []){

        $req = 'SELECT * FROM category';

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

        if($category = $this->bdd->select($req, $this->class)) {
            return $category[0];
        }else{
            return NULL;
        }
    }

    public function findAll(){

        $req = 'SELECT * FROM category';
        $categories = [];

        if($categories = $this->bdd->select($req, $this->class)) {
            return $categories;
        }else{
            return NULL;
        }
    }

    public function find(int $id){

        $req = "SELECT * FROM category WHERE id = ".$id;

        if($category = $this->bdd->select($req, $this->class)) {
            return $category[0];
        }else{
            return NULL;
        }
    }
}
