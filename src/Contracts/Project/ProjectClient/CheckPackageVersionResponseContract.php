<?php
namespace Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClient;

interface CheckPackageVersionResponseContract
{
    /**
     * Telling if package is outdated.
     * 
     * @return bool
     */
    public function isOutdated(): bool;

    /**
     * Getting package name.
     * 
     * @return string
     */
    public function getPackageName(): string;

    /**
     * Getting package version.
     * 
     * @return string
     */
    public function getPackageVersion(): string;

    /**
     * Getting new package version (if available).
     * 
     * @return string|null null if package is up-to-date.
     */
    public function getNewVersion(): ?string;
}