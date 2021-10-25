<?php
namespace Deegitalbe\TrustupVersionedPackage\Project;

use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClientContract;

/**
 * Representing a project using this package
 */
class Project implements ProjectContract
{
    /**
     * Project url
     * 
     * @var string
     */
    protected $url;

    /**
     * Project url
     * 
     * @var VersionedPackageContract
     */
    protected $versioned_package;

    /**
     * Setting this project url.
     * 
     * @return ProjectContract
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Returning this project url.
     * 
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returning versioned package related to this project.
     * 
     * @return string
     */
    public function getVersionedPackage(): VersionedPackageContract
    {
        return $this->versioned_package;
    }
    
    /**
     * Setting versioned package linked to this project.
     * 
     * @return ProjectContract
     */
    public function setVersionedPackage(VersionedPackageContract $versioned_package): ProjectContract
    {
        $this->versioned_package = $versioned_package;

        return $this;
    }

    /**
     * Getting project client.
     * 
     * @return ProjectClientContract
     */
    public function getProjectClient(): ProjectClientContract
    {
        return ProjectClient::forProject($this);
    }
}