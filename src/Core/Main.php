<?php

namespace App\Src\Core;
ini_set('display_errors', 1);

use App\Src\Controller\Homepage;
use App\Src\Controller\Request;
use App\Src\Controller\Session;

class Main
{

    public function start()
    {
        $params = [];
        $request = new Request();

        if ($request->issetGet()) {
            $params = explode('/', $request->get('get', 'p'));
        }

        if ($params[0] !== '') {

            $controller = '\\App\\Src\\Controller\\' . ucfirst(array_shift($params));

            //Check si controller existe
            $controller = new $controller();

            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                (isset($params[0])) ? $controller->$action(implode(",", $params)) : $controller->$action();
            } else {
                http_response_code(404);
                echo "Cette page n'existe pas";
            }
        } else {
            $controller = new Homepage();

            $controller->index();
        }
    }

}