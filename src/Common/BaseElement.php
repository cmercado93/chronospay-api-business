<?php

namespace Cmercado93\ChronospayApiBusiness\Common;

use Cmercado93\ChronospayApiBusiness\Auth;
use Cmercado93\ChronospayApiBusiness\Http\Http;

abstract class BaseElement
{
    private $auth;

    private $http;

    public function __construct(Auth $auth = null)
    {
        $this->auth = $auth;
    }

    public function getAuth() : Auth
    {
        return $this->auth ?? Auth::getAuth();
    }

    public function getHttp() : Http
    {
        if (!$this->http) {
            $this->http = new Http;
            $this->http->setAuth($this->getAuth());
        }

        return $this->http;
    }
}
