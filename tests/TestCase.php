<?php
namespace Deegitalbe\TrustupVersionedPackage\Tests;

use Henrotaym\LaravelTestSuite\TestSuite;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Henrotaym\LaravelHelpers\Providers\HelperServiceProvider;
use Henrotaym\LaravelApiClient\Providers\ClientServiceProvider;
use Deegitalbe\ServerAuthorization\Providers\ServerAuthorizationServiceProvider;
use Deegitalbe\TrustupVersionedPackage\Providers\TrustupVersionedPackageServiceProvider;

class TestCase extends BaseTestCase
{
    use
        TestSuite
    ;
    
    /**
     * Providers used bu application (manual registration is compulsory)
     * 
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TrustupVersionedPackageServiceProvider::class,
            ServerAuthorizationServiceProvider::class,
            HelperServiceProvider::class,
            ClientServiceProvider::class,
        ];
    }
}