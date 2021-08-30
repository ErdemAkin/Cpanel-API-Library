<?php

namespace Cpanel\Request\Uapi;

use Cpanel\Request\Handler\Uapi;

/**
 * Uapi Ftp Class
 */
class Ftp extends Uapi
{
    /**
     * Get FTP Main and Sub Accounts
     *
     * @return  array
     */
    public function getFtpAccounts(): array
    {
        $this->endpoint = $this->endpoint . "/Ftp/list_ftp";
        $this->parameters = ['include_acct_types' => "main|sub"];

        return $this->get();
    }
}