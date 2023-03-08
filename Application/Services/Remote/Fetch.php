<?php

declare(strict_types = 1);

namespace App\Services\Remote;

use BadMethodCallException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class Fetch
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $method;

    /**
     * @var array
     */
    private array $params;

    /**
     * @var array
     */
    private array $headers;

    /**
     * @var array|string[]
     */
    private array $availableMethods = ['get', 'post', 'head', 'delete', 'put', 'patch'];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->params = $data['params'] ?? [];
        $this->headers = $data['headers'] ?? [];
    }

    /**
     * @param $method
     * @param $args
     * @return void
     * @throws GuzzleException
     */
    public function __call($method, $args)
    {
        if (!in_array($method, $this->availableMethods)) {
            throw new BadMethodCallException();
        }

        $this->setUrl($args[0]);

        if (!empty($args[2])) {
            $this->setHeaders($args[2]);
        }

        return $this->fetch($method);
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @throws GuzzleException
     */
    public function fetch($method): array
    {
        $client = new Client();

        $headers = [];

        if (!empty($this->getHeaders())) {
            $headers = ['headers' => $this->getHeaders()];
        }

        $response = $client->request($method, $this->url, $headers);

        return json_decode((string)$response->getBody(), true);
    }
}