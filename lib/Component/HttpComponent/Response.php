<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\HttpComponent;

use Core\Component\ConfigComponent\RouteConfig;
use Core\ErrorHandler\Exception\ResponseException;


class Response
{
    protected RouteConfig $config;
    protected string $parsedRoute;

    /**
     * @param RouteConfig $config object containing route data defined in config.
     */
    public function __construct(RouteConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string|null $stringDate datetime string or null (e.g. if datetime database field is null).
     * @param string $format output format.
     * @return string formatted datetime string.
     */
    public function formatDate(?string $stringDate, string $format =  'd.m.Y'): string
    {
        if($stringDate)
        {
            return date ( $format , strtotime ($stringDate));
        }
        return '-';
    }

    /**
     * @param int $status redirect status as number.
     * @param null $route name of the route or generated url.
     * @param bool $isUrl if $route is url, this has to be set to true.
     */
    public function redirectToRoute(int $status, $route = null,bool $isUrl = false): void
    {
        $route= (!$isUrl) ? self::generateUrlFromRoute($route) : $route;
        header('Location: ' .$route, true, $status);
        exit;
    }

    /**
     * @param int $status redirect status as number.
     * @param string|null $url name of the designated url or null (optional).
     */
    public function redirectToUrl(int $status, string $url = null): void
    {
        header('Location: ' .$this->getProtocol().$_SERVER['HTTP_HOST'].'/'.$url, true, $status);
        exit;
    }

    /**
     * @param string $route name of designated route defined in config.
     * @param array|null $mandatory the needed route parameters (optional).
     * @param array|null $query the need get query (optional).
     * @param null $anchor the needed anchor (optional).
     * @return string url including protocol, host, request uri and optional anchor.
     */
    public function generateUrlFromRoute(string $route, array $mandatory = null, array $query = null,$anchor = null): string
    {
        $queryString = null;
        $routeData = $this->config->getRoute($route);
        $routeExpression = ltrim($routeData['expression'],'/');
        $routeArray = explode('/',$routeExpression);


        $k = 0;
        foreach($routeArray as $key => $value)
        {
            if($value === '([0-9]*)' or $value === '([a-z]*)' )
            {
                if (!isset($mandatory[$k])){
                    $k++;
                    //$mandatoryCount = count($mandatory);
                    throw new ResponseException(sprintf('Missing mandatory "%s".',$k),$route);
                }
                $routeArray[$key] = $mandatory[$k];
                $k++;
            }
        }
        $this->parsedRoute = '/'.implode('/',$routeArray);

        if($query){
            $queryString .= '?';
            foreach($query as $key => $value) {
                $queryString .= "$key=$value";
            }
        }

        if($anchor){
            $queryString .= "#$anchor";
        }
        return $this->getProtocol().$_SERVER['HTTP_HOST'].$this->parsedRoute.$queryString;
    }

    /**
     * @param string $path url path without protocol, host or trailing slash.
     * @param array|null $mandatory additional mandatory parameters (appended by trailing slashes).
     * @param null $anchor additional anchor append by #-prefix.
     * @return string full url including protocol, host, uri and anchor (without get parameters).
     */
    public function generateUrlFromString(string $path, array $mandatory = null,$anchor = null): string
    {
        if ($mandatory) {
            foreach ($mandatory as $name => $value) {
                $path .= "/$value";
            }
        }
        if($anchor){
            $path .= "#$anchor";
        }
        return $this->getProtocol().$_SERVER['HTTP_HOST'].$path;
    }

    /**
     * @return string protocol and host.
     */
    private function getProtocol(): string
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    }

}
