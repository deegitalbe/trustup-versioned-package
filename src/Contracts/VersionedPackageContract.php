<?php
namespace Deegitalbe\TrustupVersionedPackage\Contracts;

use Illuminate\Support\Collection;

/**
 * Representing a versioned package
 */
interface VersionedPackageContract
{
    /**
     * Getting projects using this package.
     * 
     * @return Collection
     */
    public function getProjects(): Collection;

    /**
     * Getting package version.
     */
    public function getVersion(): string;

    /**
     *  Getting package name
     * 
     * @return string
     */
    public function getName(): string;
}