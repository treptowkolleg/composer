<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\ErrorHandler\Exception;

class ResponseException extends RuntimeException
{
    private ?string $class;
    private ?string $method;
    private string $rawMessage;

    public function __construct(string $message, string $class = null, string $method = null, \Throwable $previous = null)
    {
        $this->class = $class;
        $this->method = $method;
        $this->rawMessage = $message;

        $this->updateRepr();

        parent::__construct($this->message, 0, $previous);
    }

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @param string|null $class
     */
    public function setClass(?string $class): void
    {
        $this->class = $class;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     */
    public function setMethod(?string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getRawMessage(): string
    {
        return $this->rawMessage;
    }

    /**
     * @param string $rawMessage
     */
    public function setRawMessage(string $rawMessage): void
    {
        $this->rawMessage = $rawMessage;
    }

    private function updateRepr()
    {
        $this->message = $this->rawMessage;

        $dot = false;
        if ('.' === substr($this->message, -1)) {
            $this->message = substr($this->message, 0, -1);
            $dot = true;
        }

        if (null !== $this->class) {
            $this->message .= sprintf(' for route %s', json_encode($this->class, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE));
        }

        if (null !== $this->method) {
            $this->message .= sprintf(' at method %d', $this->getMethod());
        }

        if ($dot) {
            $this->message .= '.';
        }
    }

}