<?php

namespace Core\Response;

class JSONResponse extends Response
{
    /**
     * JSONResponse constructor.
     *
     * @param string $message
     * @param int $code
     * @param array $data
     * @param array $headers
     */
    public function __construct($message, $code = 200, $data = [], $headers = [])
    {
        parent::__construct($message, $code, $data,  $headers);

        http_response_code($this->code);

        echo json_encode($this->formattedJSONResponse);

        exit();
    }
}