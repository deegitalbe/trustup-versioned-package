<?php
namespace Deegitalbe\TrustupVersionedPackage\Facades;

use Illuminate\Support\Facades\Facade;

class Package extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'trustup-versioned-package';
    }
}