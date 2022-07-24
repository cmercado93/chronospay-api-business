<?php

namespace Cmercado93\ChronospayApiBusiness\Exceptions;

use Curl\Curl;

class CurlException extends \Exception
{
    private $curl;

    public function __construct(Curl $curl, string $message, $code, \Throwable $previous = null)
    {
        $this->curl = $curl;

        parent::__construct($message, $code, $previous);
    }

    public function getCurl()
    {
        return $this->curl;
    }

    public function getResponseData() : array
    {
        $response = $this->curl->response->form ?: $this->curl->response;
        return json_decode(json_encode($response), 1);
    }
}
