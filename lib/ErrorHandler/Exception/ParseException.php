<?php


namespace Core\ErrorHandler\Exception;

class ParseException extends RuntimeException
{

    private ?string $parsedFile;
    private int $parsedLine;
    private ?string $snippet;
    private string $rawMessage;

    /**
     * @param string      $message    The error message
     * @param int         $parsedLine The line where the error occurred
     * @param string|null $snippet    The snippet of code near the problem
     * @param string|null $parsedFile The file name where the error occurred
     */
    public function __construct(string $message, int $parsedLine = -1, string $snippet = null, string $parsedFile = null, \Throwable $previous = null)
    {
        $this->parsedFile = $parsedFile;
        $this->parsedLine = $parsedLine;
        $this->snippet = $snippet;
        $this->rawMessage = $message;

        $this->updateRepr();

        parent::__construct($this->message, 0, $previous);
    }

    /**
     * @return string|null
     */
    public function getParsedFile(): ?string
    {
        return $this->parsedFile;
    }

    /**
     * @param string|null $parsedFile
     */
    public function setParsedFile(?string $parsedFile): void
    {
        $this->parsedFile = $parsedFile;
    }

    /**
     * @return int
     */
    public function getParsedLine(): int
    {
        return $this->parsedLine;
    }

    /**
     * @param int $parsedLine
     */
    public function setParsedLine(int $parsedLine): void
    {
        $this->parsedLine = $parsedLine;
    }

    /**
     * @return string|null
     */
    public function getSnippet(): ?string
    {
        return $this->snippet;
    }

    /**
     * @param string|null $snippet
     */
    public function setSnippet(?string $snippet): void
    {
        $this->snippet = $snippet;
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

        if (null !== $this->parsedFile) {
            $this->message .= sprintf(' in %s', json_encode($this->parsedFile, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE));
        }

        if ($this->parsedLine >= 0) {
            $this->message .= sprintf(' at line %d', $this->parsedLine);
        }

        if ($this->snippet) {
            $this->message .= sprintf(' (near "%s")', $this->snippet);
        }

        if ($dot) {
            $this->message .= '.';
        }
    }

}
