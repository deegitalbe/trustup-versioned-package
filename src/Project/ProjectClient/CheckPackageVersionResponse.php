<?php
namespace Deegitalbe\TrustupVersionedPackage\Project\ProjectClient;

use stdClass;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClient\CheckPackageVersionResponseContract;

class CheckPackageVersionResponse implements CheckPackageVersionResponseContract
{
    /**
     * Constructing based on api response.
     * 
     * @param stdClass $response
     */
    public function __construct(stdClass $response)
    {
        $this->response = $response;
    }

    /**
     * Telling if package is outdated.
     * 
     * @return bool
     */
    public function isOutdated(): bool
    {
        return $this->response->is_outdated;
    }

    /**
     * Getting package name.
     * 
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->response->package->name;
    }

    /**
     * Getting package version.
     * 
     * @return string
     */
    public function getPackageVersion(): string
    {
        return $this->response->package->version;
    }

    /**
     * Getting new package version (if available).
     * 
     * @return string|null null if package is up-to-date.
     */
    public function getNewVersion(): ?string
    {
        return $this->response->package->new_version ?? null;
    }
}