<?php

namespace Cpanel\Request\Handler;

/**
 * Request Interface
 *
 * @author Ali Erdem Akın <erdem.akin@aerotek.com.tr>
 */
interface RequestInterface
{
    /**
     * Get End Point For Request
     *
     * @return string
     */
    public function getEndPoint(): string;

    /**
     * Get Parameters For Request
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Get Base Uri For Request
     *
     * @param string $hostname
     * @return string
     */
    public function getBaseUri($hostname): string;

    /**
     * Parse Response
     *
     * @param string $result
     * @return array
     */
    public function parseResult($result): array;
}
