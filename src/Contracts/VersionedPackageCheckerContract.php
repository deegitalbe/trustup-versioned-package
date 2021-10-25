<?php
namespace Deegitalbe\TrustupVersionedPackage\Contracts;

use Illuminate\Support\Collection;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;

/**
 * Representing our versioned package checker
 */
interface VersionedPackageCheckerContract
{
    /**
     * Adding a package to this checker.
     * 
     * @param VersionedPackageContract $package
     * @return VersionedPackageCheckerContract
     */
    public function addPackage(VersionedPackageContract $package): VersionedPackageCheckerContract;

    /**
     * Getting all packages registered.
     * 
     * @return Collection
     */
    public function getPackages(): Collection;

    /**
     * Finding package by given name (if registered)
     * 
     * @return Collection
     */
    public function findPackage(string $name): ?VersionedPackageContract;

    /**
     * Checking given package.
     * 
     * @param VersionedPackageContract $package
     */
    public function checkPackage(VersionedPackageContract $package);
}