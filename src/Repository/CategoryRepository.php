<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Category;
use App\Src\Entity\Role;
use Exception;

class CategoryRepository
{

    /**
     * @var Bdd
     */
    private $bdd;

    /**
     * @var string
     */
    private $class = Category::class;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->bdd = new BDD();
    }
    // End __construct

    /**
     * @param array $parameters parameter
     *
     * @return mixed|null
     */
    public function findOneBy(array $parameters = [])
    {

        $req = 'SELECT * FROM category';

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

        if ($category = $this->bdd->select($req, $this->class)) {
            return $category[0];
        }

        return NULL;

    }

    /**
     * @return array|null
     */
    public function findAll(): ?array
    {

        $req = 'SELECT * FROM category';

        if ($categories = $this->bdd->select($req, $this->class)) {
            return $categories;
        }

        return NULL;

    }

    /**
     * @param int $idCategory parameter
     *
     * @return mixed|null
     */
    public function find(int $idCategory)
    {

        $req = "SELECT * FROM category WHERE id = ".$idCategory;

        if ($category = $this->bdd->select($req, $this->class)) {
            return $category[0];
        }

        return NULL;

    }
}
