<?php

namespace Cpanel\Request\Handler;

use Cpanel\Exception\ConnectionException;
use Cpanel\Client;

/**
 * Uapi Abstract
 *
 * @author Ali Erdem Akın <erdem.akin@aerotek.com.tr>
 */
abstract class Uapi implements RequestInterface
{
    /**
     * Client
     *
     * @var Client
     */
    protected $client;

    /**
     * Uapi Base End Point
     *
     * @var string
     */
    protected $endpoint = "/execute";

    /**
     * Request Parameters
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Default Command
     * 
     * @var string
     */
    protected $command = "UApi";

    /**
     * Construct
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        if(empty($client)) {
            throw new InvalidArgumentException('First you have to construct the Client class.');
        }
        $this->client = $client;
    }

    /**
     * Set End Point For Request
     *
     * @param string $endpoint
     * @return self
     */
    public function setEndPoint($endpoint): self
    {
        $this->endpoint .= $endpoint;
        return $this;
    }

    /**
     * Get End Point For Request
     *
     * @return string
     */
    public function getEndPoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Set Parameters For Request
     *
     * @param array $parameters
     * @return self
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * Get Parameters For Request
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Get Base Uri For Request
     *
     * @param string $hostname
     * @return string
     */
    public function getBaseUri($hostname): string
    {
        return "https://" . $hostname . ":2083";
    }

    /**
     * Parse Response
     *
     * @param string $result
     * @return array
     */
    public function parseResult($result): array
    {
        $parsed_result = json_decode($result,true);

        if (is_null($parsed_result)) {
            throw new ConnectionException("An unspecified error has occurred. Check the connection information.");
        }

        // Check for Errors
        if (isset($parsed_result['status']) && $parsed_result['status'] == 0) {
            throw new ResponseException($parsed_result['errors'][0]);
        }

        return $parsed_result;
    }

    protected function get(): array
    {
        $httpClient = $this->client->getHttpClient($this);

        $response = $httpClient->get(
            $this->getEndPoint(),
            [
                "form_params" => $this->getParameters(),
            ]
        );

        return $this->parseResult($response->getBody()->getContents());
    }

    protected function post(): array
    {
        $httpClient = $this->client->getHttpClient($this);

        $response = $httpClient->post(
            $this->getEndPoint(),
            [
                "form_params" => $this->getParameters(),
            ]
        );

        return $this->parseResult($response->getBody()->getContents());
    }
}