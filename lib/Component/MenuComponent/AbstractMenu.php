<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\MenuComponent;

use Core\Component\ConfigComponent\RouteConfig;
use Core\Component\HttpComponent\Response;

abstract class AbstractMenu
{

    protected array $menuCollection;
    protected Response $response;
    protected $user;


    public function __construct($user = false)
    {
        $config = new RouteConfig('config/routes.yaml');
        $this->response = new Response($config);
        $this->user = $user;
    }

    public function HideUnlessHasPermission(string $condition): bool
    {
        if($this->user) {
            foreach ($this->user->getPermissions() as $permission) {
                if ($condition == $permission->getLabel()) {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * @param array $collection
     * @return AbstractMenu
     */
    public function createMenu(array $collection = []): AbstractMenu
    {
        return $this;
    }

    protected function add(string $name, string $menuType, array $options = [], array $mandatory = null): AbstractMenu
    {
        $menuType = new $menuType;
        if(!empty($options))
        {
            foreach($options as $option => $value)
            {
                $value = ($option === 'route') ? $this->response->generateUrlFromRoute($value,$mandatory) : $value;
                $option = ucfirst($option);
                $method = "set{$option}";
                $menuType->$method($value);
            }
        }
        $requestUri = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
        $requestUri .= "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if(strpos($requestUri,'?'))
        {
            $requestUriArray = explode('?',$requestUri);
        } else {
            $requestUriArray[0] = $requestUri;
        }

        if($menuType->getRoute() === $requestUriArray[0])
        {
            $menuType->setAttrib('class', 'active');
        }
        $this->menuCollection[] = $menuType;
        return $this;
    }

    public function render(): array
    {
        return $this->menuCollection;
    }

}