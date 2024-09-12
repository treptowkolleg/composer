<?php

namespace Core\ErrorHandler;

use Core\Controller\AbstractController;
use Exception;

class ExceptionHandler extends AbstractController
{

    private Exception $exception;

    public function __construct(Exception $exception)
    {
        parent::__construct();
        $this->exception = $exception;

    }

    public function renderView()
    {
        include (project_root.'/bundles/error_bundle/templates/stack_trace.html.php');
    }

    /**
     * @return Exception
     */
    public function getException(): Exception
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception): void
    {
        $this->exception = $exception;
    }

}
