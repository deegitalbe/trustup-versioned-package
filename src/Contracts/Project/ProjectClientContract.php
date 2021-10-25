<?php
namespace Deegitalbe\TrustupVersionedPackage\Contracts\Project;

use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;

/**
 * Representing requests that are available between our projects.
 */
interface ProjectClientContract
{
    /**
     * Project linked to this client.
     * 
     * @return ProjectContract
     */
    public function getProject(): ProjectContract;

    /**
     * Setting project linked to this client.
     * 
     * @return ProjectClientContract
     */
    public function setProject(ProjectContract $project): ProjectClientContract;

    /**
     * Checking package version for this project.
     * 
     * @return bool|null telling is package is outdated (null if error occured).
     */
    public function checkPackageVersion(): ?bool;

    /**
     * Construct project client based on given project.
     * 
     * @param ProjectContract $project
     * @return ProjectClientContract
     */
    public static function forProject(ProjectContract $project): ProjectClientContract;
}