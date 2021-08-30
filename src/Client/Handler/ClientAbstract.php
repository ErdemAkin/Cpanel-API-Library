<?php

namespace Cpanel\Client\Handler;

use Cpanel\Exception\InvalidArgumentException;
use Cpanel\Request\Handler\RequestInterface;
use GuzzleHttp\Client;

/**
 * ClientAbstract
 *
 * @author Ali Erdem Akın <erdem.akin@aerotek.com.tr>
 */
abstract class ClientAbstract implements ClientInterface
{
    /**
     * Cpanel Hostname
     *
     * @var string
     */
    private $hostname;

    /**
     * Cpanel Username
     *
     * @var string
     */
    private $username;

    /**
     * Cpanel Password
     *
     * @var string
     */
    private $password;

    /**
     * Cpanel Api Token
     *
     * @var string
     */
    private $apitoken;

    /**
     * Cpanel Access Hash
     *
     * @var string
     */
    private $accessHash;

    /**
     * Cpanel Authorization Header
     *
     * @var array
     */
    private $authorization;

    /**
     * Constructor
     */
    public function __construct(string $hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Authenticate By Accesss Hash For Whm
     *
     * @param string $accessHash
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByAccessHashForWhm(string $accessHash): self
    {
        if (empty($accessHash)) {
            throw new InvalidArgumentException('You need to specify access hash!');
        }

        $this->accessHash = $accessHash;
        $this->authorization = ["Authorization" => "WHM root:" . preg_replace("'(\r|\n)'", "", $accessHash)];

        return $this;
    }

    /**
     * Authenticate By Api Token Hash For Whm
     *
     * @param string $username
     * @param string $apitoken
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByApiTokenForWhm(string $username, string $apitoken): self
    {
        if (empty($username) || empty($apitoken)) {
            throw new InvalidArgumentException('You need to specify username and apitoken!');
        }

        $this->username = $username;
        $this->apitoken = $apitoken;
        $this->authorization = ["Authorization" => "whm {$username}:{$apitoken}"];

        return $this;
    }

    /**
     * Authenticate By Api Token Hash For Cpanel
     *
     * @param string $username
     * @param string $apitoken
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByApiTokenForCpanel(string $username, string $apitoken): self
    {
        if (empty($username) || empty($apitoken)) {
            throw new InvalidArgumentException('You need to specify username and apitoken!');
        }

        $this->username = $username;
        $this->apitoken = $apitoken;
        $this->authorization = ["Authorization" => "cpanel {$username}:{$apitoken}"];

        return $this;
    }

    /**
     * Authenticate By Username Password Hash For Cpanel And Whm
     *
     * @param string $username
     * @param string $password
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByUsernamePassword(string $username, string $password): self
    {
        if (empty($username) || empty($password)) {
            throw new InvalidArgumentException('You need to specify username and password!');
        }

        $this->username = $username;
        $this->password = $password;
        $this->authorization = ["Authorization" => "Basic " . base64_encode($username . ":" . $password) . "\n\r"];

        return $this;
    }

    /**
     * Get Http Client
     *
     * @return Client
     */
    public function getHttpClient(RequestInterface $request): Client
    {
        if (empty($this->authorization)) {
            throw new InvalidArgumentException('This process cannot be done without authentication!');
        }

        $httpClient = new Client([
            'base_uri' => $request->getBaseUri($this->hostname),
            'headers' => $this->authorization,
            'http_errors' => false,
            'verify' => false,
        ]);

        return $httpClient;
    }
}
