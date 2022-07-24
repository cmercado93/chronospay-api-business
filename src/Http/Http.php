<?php

namespace Cmercado93\ChronospayApiBusiness\Http;

use Cmercado93\ChronospayApiBusiness\Auth;
use Cmercado93\ChronospayApiBusiness\Exceptions\CurlException;
use Curl\Curl;

class Http
{
    protected $baseUrl;

    protected $auth;

    public function __construct(string $baseUrl = null)
    {
        $this->baseUrl = $baseUrl;
    }

    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getAuth() : ?Auth
    {
        return $this->auth;
    }

    public function getBaseUrl() : string
    {
        return $this->baseUrl ?? $this->getAuth()->getBaseUrl();
    }

    public function post(string $uri, array $data, array $query = []) : array
    {
        return $this->exec('POST', $uri, [
            'body' => $data,
            'query' => $query,
        ]);
    }

    public function get(string $uri, array $query = []) : array
    {
        return $this->exec('GET', $uri, [
            'query' => $query,
        ]);
    }

    public function put(string $uri, array $data = [], array $query = []) : array
    {
        return $this->exec('PUT', $uri, [
            'body' => $data,
            'query' => $query,
        ]);
    }

    public function downloadFile(string $uri, $callback) : bool
    {
        $url = $this->makeUrl($uri, $data['query'] ?? []);

        $curl = $this->getFreshInstanceCurl();

        return $curl->download($url, $callback);
    }

    protected function getFreshInstanceCurl() : Curl
    {
        $curl = new Curl;

        $curl->setHeader('Accept', 'application/json');

        if ($this->getAuth()) {
            $curl->setHeader('access-token', $this->getAuth()->getAccessToken());
        }

        $curl->setFollowLocation();

        return $curl;
    }

    protected function parseResponse(Curl $curl) : array
    {
        if ($curl->error) {
            throw new CurlException($curl, $curl->errorMessage, $curl->errorCode);
        }

        $response = $curl->response->form ?: $curl->response;

        return json_decode(json_encode($response ?: []), 1);
    }

    protected function exec(string $method, string $uri, array $data, array $headers = []) : array
    {
        $url = $this->makeUrl($uri, $data['query'] ?? []);

        $curl = $this->getFreshInstanceCurl();

        switch($method) {
            case 'GET':
                $curl->get($url);
                break;
            case 'POST':
                $curl->setHeader('Content-Type', 'multipart/form-data');

                $curl->post($url, $data['body'] ?? []);
                break;
            case 'PUT':
                $curl->put($url, $data['body'] ?? []);
                break;
        }

        return $this->parseResponse($curl);
    }

    protected function makeUrl(string $uri, array $query = []) : string
    {
        $baseUrl = $this->parseUrl($uri);

        $query = explode('&', $baseUrl['query'] ?? '');

        foreach ($query as $k => $v) {
            if ($v) {
                array_push($query, (string)$k . '=' . (string)$v);
            }
        }

        $baseUrl['query'] = implode('&', $query);

        return $baseUrl['scheme'] . '://' . $baseUrl['host'] . '/' . trim($baseUrl['path'], '/') . ($baseUrl['query'] ? ('?' . $baseUrl['query']) : '');
    }

    protected function parseUrl(string $uri) : array
    {
        return parse_url(trim($this->getBaseUrl(), '/') . '/' . trim($uri, '/'));
    }
}
