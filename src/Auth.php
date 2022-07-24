<?php

namespace Cmercado93\ChronospayApiBusiness;

use Cmercado93\ChronospayApiBusiness\Http\Http;

class Auth
{
    protected static $self;

    protected $baseUrl;

    protected $username;

    protected $password;

    protected $accessToken;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function login(string $username, string $password)
    {
        if ($this->accessToken) {
            return $this;
        }

        $http = new Http($this->baseUrl);

        $this->username = $username;

        $this->password = $password;

        $response = $http->post('/api-business/auth/login', [], [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $this->accessToken = $response['token'];
    }

    public static function initLogin(string $baseUrl, string $username, string $password)
    {
        $self = new static($baseUrl);

        $self->login($username, $password);

        static::$self = $self;
    }

    public static function getAuth() : ?Auth
    {
        return static::$self;
    }

    public function getBaseUrl() : string
    {
        return $this->baseUrl;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getAccessToken() : string
    {
        return $this->accessToken;
    }
}
