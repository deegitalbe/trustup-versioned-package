<?php
namespace Deegitalbe\TrustupVersionedPackage\Contracts\Project;

use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClient\CheckPackageVersionResponseContract;

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
     * @param string $version Version to check. if none given, actual one (in this application) is used.
     * @return CheckPackageVersionResponseContract|null null if error occured.
     */
    public function checkPackageVersion(string $version = null): ?CheckPackageVersionResponseContract;

    /**
     * Getting package version for this project.
     * 
     * @return string|null null if error occured.
     */
    public function getPackageVersion(): ?string;

    /**
     * Construct project client based on given project.
     * 
     * @param ProjectContract $project
     * @return ProjectClientContract
     */
    public static function forProject(ProjectContract $project): ProjectClientContract;
}