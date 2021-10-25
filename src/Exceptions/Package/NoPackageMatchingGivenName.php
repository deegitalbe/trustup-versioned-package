<?php
namespace Deegitalbe\TrustupVersionedPackage\Exceptions\Package;

use Exception;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageCheckerContract;

class NoPackageMatchingGivenName extends Exception
{
    protected $message = "No registered package matching given name.";

    /**
     * Package name not found
     * 
     * @var string
     */
    protected $name;

    /**
     * Setting up name not found.
     * 
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getting name not found.
     * 
     * @param string $name
     * @return self
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Exception context.
     * 
     * @return array
     */
    public function context()
    {
        return [
            'name' => $this->getName(),
            'packages' => app()->make(VersionedPackageCheckerContract::class)->getPackages()->map(function(VersionedPackageContract $package) {
                return [
                    'name' => $package->getName(),
                    'version' => $package->getVersion()
                ];
            })
        ];
    }
}