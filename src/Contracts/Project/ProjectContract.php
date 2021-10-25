<?php
namespace Deegitalbe\TrustupVersionedPackage\Contracts\Project;

use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClientContract;

/**
 * Representing a project using this package
 */
interface ProjectContract
{
    /**
     * Returning this project url.
     * 
     * @return string
     */
    public function getUrl(): string;
    /**
     * Setting this project url.
     * 
     * @return ProjectContract
     */
    public function setUrl(string $url): ProjectContract;

    /**
     * Returning versioned package related to this project.
     * 
     * @return string
     */
    public function getVersionedPackage(): VersionedPackageContract;
    
    /**
     * Setting versioned package linked to this project.
     * 
     * @return ProjectContract
     */
    public function setVersionedPackage(VersionedPackageContract $versioned_package): ProjectContract;

    /**
     * Getting project client.
     * 
     * @return ProjectClientContract
     */
    public function getProjectClient(): ProjectClientContract;
}