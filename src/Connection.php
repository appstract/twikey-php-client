<?php

namespace Appstract\Twikey;

use Appstract\Twikey\Exceptions\ApiException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Connection
{
    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    private $apiToken;


    private $authorizationToken = '';

    /**
     * @var Client
     */
    private $client;


    public function setApiUrl($url) {
        $this->apiUrl = $url;
    }

    /**
     * @param mixed $apiToken
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @param mixed $authorizationToken
     */
    public function setAuthorizationToken($authorizationToken)
    {
        $this->authorizationToken = $authorizationToken;
    }

    public function login()
    {
        $request = $this->createRequest(
            'POST', $this->formatUrl('', 'POST'), ['apiToken' => $this->apiToken]
        );

        $response = $this->parseResponse(
            $this->client()->send($request)
        );

        if (isset($response['Authorization'])) {
            $this->authorizationToken = $response['Authorization'];
        } else {
            throw new ApiException('Failed to login');
        }
    }
    /**
     * [get description].
     * @param  [type]  $url      [description]
     * @param  array   $requestParams   [description]
     * @param  bool $fetchAll [description]
     * @return [type]            [description]
     */
    public function get($url, array $requestParams = [])
    {
        try {
            $request = $this->createRequest(
                'GET', $this->formatUrl($url, 'get'), null, $requestParams
            );

            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * @param string $url
     * @param string $body
     *
     * @return mixed
     * @throws ApiException
     */
    public function post($url, $body)
    {
        try {
            $request = $this->createRequest(
                'POST', $this->formatUrl($url, 'post'), $body
            );

            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * @param string $url
     * @param string $body
     * @return mixed
     * @throws ApiException
     */
    public function patch($url, $body)
    {
        try {
            $request = $this->createRequest(
                'PATCH', $this->formatUrl($url, 'patch'), $body
            );

            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * @return Client
     */
    private function client()
    {
        if ($this->client) {
            return $this->client;
        }

        $this->client = new Client([
            'http_errors' => true,
            'expect' => false,
        ]);

        return $this->client;
    }

    private function createRequest(
        $method,
        $endpoint,
        $body = null,
        $params = [],
        $headers = []
    ) {
        // Add default json headers to the request
        $headers = array_merge($headers, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $this->authorizationToken
        ]);

        // Create param string
        if (! empty($params)) {
            $endpoint .= '?'.http_build_query($params);
        }

        // Create the request
        return new Request($method, $endpoint, $headers, $body ? http_build_query($body) : null);
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return string
     */
    private function formatUrl($url, $method = 'get')
    {
        return "{$this->apiUrl}/$url";
    }

    /**
     * @param Response $response
     * @return mixed
     * @throws ApiException
     */
    private function parseResponse(Response $response)
    {
        try {
            Psr7\rewind_body($response);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\RuntimeException $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
