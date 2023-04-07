<?php

namespace App\Src\Core;

use App\Src\Controller\Homepage;
use App\Src\Controller\Request;
use App\Src\Controller\Session;

class Main
{


    /**
     * @return void
     */
    public function start()
    {
        $params = [];
        $request = new Request();

        if ($request->get('get', 'p') !== NULL) {
            $params = explode('/', $request->get('get', 'p'));
        }

        if ($params[0] !== '') {
            $controller = '\\App\\Src\\Controller\\'.ucfirst(array_shift($params));

            $controller = new $controller();

            $action = (isset($params[0])) === TRUE ?
                array_shift($params) :
                'index';

            if (method_exists($controller, $action) === TRUE) {
                (isset($params[0])) === TRUE ?
                    $controller->$action(implode(",", $params)) :
                    $controller->$action();
            } else {
                $errorController = new Homepage();
                $errorController->notFound();
            }
        } else {
            $controller = new Homepage();

            $controller->index();
        }

        // End start()
    }


}
