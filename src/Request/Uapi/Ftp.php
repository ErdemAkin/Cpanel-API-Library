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
        $this->setEndPoint("/Ftp/list_ftp");
        $this->setParameters(['include_acct_types' => "main|sub"]);

        return $this->get();
    }

    /**
     * Update FTP Account Password
     *
     * @param	string $domain
     * @param	string $username
     * @param	string $password
     * @return  array
     */
    public function updateFtpPassword(string $username, string $password, string $domain = null): array
    {
        $parameters = [
            'user' => $username,
            'pass' => $password
        ];

        empty($domain) ?: $parameters['domain'] = $domain;

        $this->setEndPoint("/Ftp/passwd");
        $this->setParameters($parameters);

        return $this->get();
    }

    /**
     * Update FTP Account Quota
     *
     * @param	string $username
     * @param	integer	$quota
     * @param	array $extra
     * @return	array
     */
    public function updateFtpQuota(string $username, int $quota, array $extra = []): array
    {
        $parameters = [
            'user' => $username,
            'quota' => $quota
        ];

        $parameters = array_merge($parameters, $extra);

        $this->setEndPoint("/Ftp/set_quota");
        $this->setParameters($parameters);

        return $this->get();
    }

    /**
     * Add FTP Account
     *
     * @param	string $username
     * @param	string $password
     * @param	string $homedir
     * @param	integer	$quota
     * @param	array $extra
     * @return  array
     */
    public function addFtpAccount(string $username, string $password, string $homedir = null, int $quota = null, array $extra = []): array
    {
        $parameters = [
            'user' => $username,
            'pass' => $password
        ];

        is_null($homedir) ?: $parameters['homedir'] = $homedir;
        is_null($quota) ?: $parameters['quota'] = $quota;

        $parameters = array_merge($parameters, $extra);

        $this->setEndPoint("/Ftp/add_ftp");
        $this->setParameters($parameters);

        return $this->get();
    }

    /**
     * Delete FTP Account
     *
     * @param	string $username
     * @param	int	$destroy
     * @param	string	$domain
     * @return  array
     */
    public function deleteFtpAccount(string $username, int $destroy = 0, string $domain = null): array
    {
        $parameters = [
            'user' => $username,
            'destroy' => $destroy
        ];

        is_null($domain) ?: $parameters['domain'] = $domain;

        $this->setEndPoint("/Ftp/delete_ftp");
        $this->setParameters($parameters);

        return $this->get();
    }
}