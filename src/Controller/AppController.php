<?php

namespace App\Controller;

use Core\Controller\AbstractController;

class AppController extends AbstractController
{

    public function index(int $id = null): string
    {
        $this->meta->add('title','Hello World!');
        $routeUrls = [];
        // Routen, die zusätzliche Werte benötigen, werden ignoriert.
        foreach($this->getRoutes()->getArguments() as $route => $content) {
            try {
                $routeUrls[$route] = $this->generateUrlFromRoute($route);
            } catch (\Exception $e) {

            }
        }

        return $this->render('app/index.html', [
            'controllerName' => "AppController",
            'routes' => $routeUrls
        ]);
    }

    public function show(): string
    {
        $this->denyAccessUnlessLogin();
        $this->meta->add('title','Willkommen!');

        return "Du bist eingeloggt.";
    }

}