<?php

namespace App\Src\Core;
ini_set('display_errors', 1);

use App\Src\Controller\Homepage;

class Main{

    public function start(){
        $uri = $_SERVER['REQUEST_URI'];

        $params = [];
        //filter_input(input_GET, 'p')
        if(isset($_GET['p'])) {
            $params = explode('/', filter_input(INPUT_GET, 'p'));
        }

        if ($params[0] !== ''){

            $controller = '\\App\\Src\\Controller\\'. ucfirst(array_shift($params));

            //Check si controller existe
            $controller = new $controller();

            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)){
                (isset($params[0])) ? $controller->$action($params) : $controller->$action();
            }else{
                http_response_code(404);
                echo "Cette page n'existe pas";
            }
        }else{
            $controller = new Homepage();

            $controller->index();
        }
    }

}