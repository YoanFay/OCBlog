<?php

namespace App\Src\Controller;

use App\Src\Repository\ConfigRepository;

class Admin extends Controller{

    public function index(){
        $configRepository = new ConfigRepository();
        $config = $configRepository->findOne();

        $this->render('admin/index', [
            "config" => $config,
        ]);
    }

}