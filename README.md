# cPanel API

New generation cPanel API

## Description
It is a library developed to use Cpanel APIs. Influenced by different design patterns and attention was paid to the OOP structure. The library is modular and extensible. 


## Installing

You can install via composer

## Usage

### General Usage;

```
use Cpanel\Client;

$client = new Client($domain);
$client->authenticateByUsernamePassword($username, $password);
```

### There are different authentication methods;

```
$client->authenticateByAccessHashForWhm($accessHash);
$client->authenticateByApiTokenForWhm($username, $apitoken);
$client->authenticateByApiTokenForCpanel($username, $apitoken);
$client->authenticateByUsernamePassword($username, $password);
```

### UApi Usage;

```
$ftp      = new Ftp($client);
$ftpResponse = $ftp->getFtpAccounts();

$subDomain = new Subdomain($client);
$subDomainResponse = $subDomain->createSubdomain($subdomain,$maindomain);
```

### Catching Errors

There are 5 different custom exceptions.
 - CpanelErrorException
 - ConnectionException
 - InvalidArgumentException
 - MissingParameterException
 - ResponseException

It can be used as: 
```
use Cpanel\Exception\ConnectionException;
use Cpanel\Exception\InvalidArgumentException;
use Cpanel\Exception\MissingParameterException;
use Cpanel\Exception\ResponseException;

try {
    // Your code is here
} catch (InvalidArgumentException $ex) {
    echo $ex->getMessage();
} catch (ConnectionException $ex) {
    echo $ex->getMessage();
} catch (MissingParameterException $ex) {
    echo $ex->getMessage();
} catch (ResponseException $ex) {
    echo $ex->getMessage();
}
```

If we want to catch all errors with one exception, we can use it like this.

```
use Cpanel\Exception\CpanelErrorException;

try {
    // Your code is here
} catch (CpanelErrorException $ex) {
    echo $ex->getMessage();
}
```

## Example Code
```
use Cpanel\Client;
use Cpanel\Exception\ConnectionException;
use Cpanel\Exception\InvalidArgumentException;
use Cpanel\Exception\MissingParameterException;
use Cpanel\Exception\ResponseException;
use Cpanel\Request\Uapi\Ftp;
use Cpanel\Request\Uapi\Subdomain;

try {
    $client = new Client("domain.com");
    $client->authenticateByUsernamePassword("username", "password");

    $ftp      = new Ftp($client);
    $ftpResponse = $ftp->getFtpAccounts();

    $subDomain = new Subdomain($client);
    $subDomainResponse = $subDomain->createSubdomain('apitest','domain.com');

} catch (InvalidArgumentException $ex) {
    echo "InvalidArgumentException => " . $ex->getMessage();
} catch (ConnectionException $ex) {
    echo "ConnectionException => " . $ex->getMessage();
} catch (MissingParameterException $ex) {
    echo "MissingParameterException =>" . $ex->getMessage();
} catch (ResponseException $ex) {
    echo "ResponseException => " . $ex->getMessage();
} catch (\Throwable $th) {
    echo "An unexpected error was received";
}

```

## Authors

* **Ali Erdem Akın**

