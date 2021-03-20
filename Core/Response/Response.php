<?php

namespace Core\Response;

abstract class Response
{
    protected $message;
    protected $code;
    protected $data = [];
    protected $headers = [];
    protected $formattedJSONResponse = [];

    public function __construct(string $message, int $code, array $data = [], array $headers = [])
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
        $this->headers = $headers;

        $this->setHeaders();

        $this->setFormattedData();
    }

    /**
     * Set additional headers for response
     */
    private function setHeaders(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }
    }

    public function setFormattedData()
    {
        $this->formattedJSONResponse = [
            'message' => $this->message,
            'code' => $this->code,
            'data' => $this->data
        ];
    }
}