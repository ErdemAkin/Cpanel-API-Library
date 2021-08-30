<?php

namespace Cpanel\Request\Uapi;

use Cpanel\Request\Handler\Uapi;

/**
 * Uapi Subdomain Class
 */
class Subdomain extends Uapi
{
    public function createSubdomain(string $domain, string $rootDomain, string $directory = null): array
    {
        $this->endpoint = $this->endpoint . "/SubDomain/addsubdomain";
        $this->parameters = [
            'domain' => $domain,
            'rootdomain' => $rootDomain
        ];

        empty($directory) ?: $this->parameters['$directory'] = $directory;

        return $this->get();
    }
}