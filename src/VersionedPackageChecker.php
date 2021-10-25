<?php
namespace Deegitalbe\TrustupVersionedPackage;

use Illuminate\Support\Collection;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;

/**
 * Representing our versioned package checker
 */
class VersionedPackageChecker implements VersionedPackageCheckerContract
{
    /**
     * Packages registered.
     * 
     * @var Collection
     */
    protected $packages;

    /**
     * Construction instance
     * 
     * @return void
     */
    public function __construct()
    {
        $this->packages = collect();
    }

    /**
     * Adding a package to this checker.
     * 
     * @param VersionedPackageContract $package
     * @return VersionedPackageCheckerContract
     */
    public function addPackage(VersionedPackageContract $package): VersionedPackageCheckerContract
    {
        $this->packages->push($package);

        return $this;
    }

    /**
     * Getting all packages registered.
     * 
     * @return Collection
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    /**
     * Checking given package.
     * 
     * @param VersionedPackageContract $package
     */
    public function checkPackage(VersionedPackageContract $package)
    {

    }

    /**
     * Finding package by given name (if registered)
     * 
     * @return Collection
     */
    public function findPackage(string $name): ?VersionedPackageContract
    {
        return $this->packages->first(function(VersionedPackageContract $package) {
            return $package->getName() === $name;
        });
    }
}