<?php

namespace App\Controller;

use Core\Controller\AbstractController;

class NotFoundController extends AbstractController
{

    public function notFound($uri = null): void
    {
        $this->meta->add('title','Seite nicht gefunden!');
        $url = (null !== $uri)? $this->response->generateUrlFromString($uri) : null;

        echo $this->render('error/not_found.html', [
            'url' => $url,
        ]);
    }

}