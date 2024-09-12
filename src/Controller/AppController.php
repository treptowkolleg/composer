<?php

namespace App\Controller;

use Core\Controller\AbstractController;

class AppController extends AbstractController
{

    public function index(int $id = null): string
    {
        return $this->render('app/index.html', [
            'controllerName' => "AppController",
        ]);
    }

}