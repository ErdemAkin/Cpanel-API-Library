<?php

namespace Cpanel\Client\Handler;

/**
 * Request Interface
 *
 * @author Ali Erdem Akın <erdem.akin@aerotek.com.tr>
 */
interface ClientInterface
{
    /**
     * Authenticate By Accesss Hash For Whm
     *
     * @param string $accessHash
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByAccessHashForWhm(string $accessHash): self;

    /**
     * Authenticate By Api Token Hash For Whm
     *
     * @param string $username
     * @param string $apitoken
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByApiTokenForWhm(string $username, string $apitoken): self;

    /**
     * Authenticate By Api Token Hash For Cpanel
     *
     * @param string $username
     * @param string $apitoken
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByApiTokenForCpanel(string $username, string $apitoken): self;

    /**
     * Authenticate By Username Password Hash For Cpanel And Whm
     *
     * @param string $username
     * @param string $password
     * @return self
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticateByUsernamePassword(string $username, string $password): self;

}
