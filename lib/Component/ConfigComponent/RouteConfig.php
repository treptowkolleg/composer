<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\ConfigComponent;

class RouteConfig extends AbstractConfig implements RouteConfigInterface
{

    public function __construct(string $file)
    {
        parent::__construct($file);
    }


    public function setRoute(Array $data): RouteConfig
    {
        $this->setArgument($data);
        return $this;
    }

    public function getRoute(string $route)
    {
        return $this->getArgument($route);
    }

}
