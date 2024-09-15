<?php

namespace App\Controller\Api;

use Core\Controller\AbstractController;

class CharacterController extends AbstractController
{

    public function getCharacters(): string
    {
        if($this->request->isPostRequest()) {
            $chars = [
                "Cloud",
                "Tifa",
                "Barret",
                "Yuffie"
            ];
            $body = json_decode(file_get_contents('php://input'));
            foreach ($body as $key => $value) {
                $chars[$key] = $value;
            }
            http_response_code(201);
            return json_encode($chars);
        }
        http_response_code(404);
        return "";
    }

}