<?php
namespace Deegitalbe\TrustupVersionedPackage;

use Illuminate\Support\Collection;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;

class Package
{
    /**
     * Getting package version (useful to make sure projetcs use same version).
     * 
     * @return string
     */
    public function version(): string
    {
        return "1.0.4";
    }

    /**
     * Getting package prefix.
     * 
     * @return string
     */
    public function prefix(): string
    {
        return "trustup-versioned-package";
    }

    // /**
    //  * Getting config value.
    //  * Prefix is automatically added to given key.
    //  * 
    //  * @param string $key key to get in config file.
    //  * @return mixed
    //  */
    // public function config(string $key = null)
    // {
    //     return config($this->prefix(). ($key ? ".$key" : ''));
    // }
}