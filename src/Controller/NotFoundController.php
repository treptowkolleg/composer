<?php

namespace App\Controller;

use Core\Controller\AbstractController;

class NotFoundController extends AbstractController
{

    public function notFound($uri = null): void
    {
        $url = (null !== $uri)? $this->response->generateUrlFromString($uri) : null;

        print "Die Url {$url} ist nicht oder nicht mehr vorhanden!";
    }

}