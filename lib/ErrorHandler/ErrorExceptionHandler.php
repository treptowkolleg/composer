<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\ErrorHandler;

use Core\Controller\AbstractController;
use Error;

class ErrorExceptionHandler extends AbstractController
{

    private Error $exception;

    public function __construct(Error $exception)
    {
        parent::__construct();
        $this->exception = $exception;

    }

    public function renderView()
    {
        include (project_root.'/bundles/error_bundle/templates/stack_trace.html.php');
    }

    /**
     * @return Error
     */
    public function getException(): Error
    {
        return $this->exception;
    }

    /**
     * @param Error $exception
     */
    public function setException(Error $exception): void
    {
        $this->exception = $exception;
    }

}
