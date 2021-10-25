<?php
namespace Deegitalbe\TrustupVersionedPackage\Exceptions\Package;

use Exception;
use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;

class VersionedPackageOutdated extends Exception
{
    /**
     * Package related to this error.
     * 
     * @var VersionedPackageContract
     */
    protected $package;

    /**
     * New package version available.
     * 
     * @var string
     */
    protected $new_version;

    /**
     * Constructing exception with appropriated message.
     * 
     * @param VersionedPackageContract
     * @return self
     */
    public static function getException(VersionedPackageContract $package): self
    {
        return (new self("Package {$package->getName()} is outdated."))
            ->setPackage($package);
    }

    /**
     * Setting up versioned package.
     * 
     * @param VersionedPackageContract $package
     * @return self
     */
    public function setPackage(VersionedPackageContract $package): self
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Setting up new available version.
     * 
     * @param string $new_version
     * @return self
     */
    public function setNewVersion(string $new_version): self
    {
        $this->new_version = $new_version;

        return $this;
    }


    /**
     * Exception context.
     * 
     * @return array
     */
    public function context()
    {
        return [
            'name' => $this->package->getName(),
            'actual_version' => $this->package->getVersion(),
            'new_version' => $this->new_version
        ];
    }
}