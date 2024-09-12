<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\HttpComponent;


class Request
{

    /**
     * @var string
     */
    public string $csrf_token;

    public ?string $query;


    public function __construct()
    {
    }

    public function setToken($csrfToken)
    {
        $this->csrf_token = $csrfToken;
    }

    /**
     * @return bool
     */
    public function isPostRequest(): bool
    {
        return (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST');
    }

    /**
     * @return bool
     */
    public function isGetRequest(): bool
    {
        return (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET');
    }

    /**
     * @return bool
     */
    public function isFormSubmitted(): bool
    {
        $token = ($this->getFieldAsString('csrf_token'))??null;
        return $token == $this->csrf_token;
    }

    /**
     * @param string $FormFieldName
     * @return string|null
     */
    public function getFieldAsString(string $FormFieldName): ?string
    {
        $query = filter_input(INPUT_POST, $FormFieldName, FILTER_SANITIZE_STRIPPED);
        return $this->query = $query ?? null;
    }

    /**
     * @param string $FormFieldName
     * @return array|null
     */
    public function getFieldAsArray(string $FormFieldName): ?array
    {
        return $query = (isset($_POST[$FormFieldName]))?$_POST[$FormFieldName]:null;
    }

    /**
     * @param string $FormFieldName
     * @return mixed
     */
    public function getFieldAsFile(string $FormFieldName): mixed
    {
        return $query = (isset($_FILES[$FormFieldName]))?$_FILES[$FormFieldName]:null;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getQueryAsString(string $key): ?string
    {
        $query = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRIPPED);
        return $this->query = $query ?? null;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getQueryAsArray(string $key): mixed
    {
        return $query = (isset($_GET[$key]))?$_GET[$key]:null;
    }
}
