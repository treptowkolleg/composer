<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\ConfigComponent;

interface RouteConfigInterface
{
    /**
     * @param array $data
     * @return $this
     */
    public function setRoute(array $data): RouteConfig;

    /**
     * @param string $route
     * @return mixed
     */
    public function getRoute(string $route);

}