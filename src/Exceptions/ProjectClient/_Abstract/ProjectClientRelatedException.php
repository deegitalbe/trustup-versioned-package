<?php
namespace Deegitalbe\TrustupVersionedPackage\Exceptions\ProjectClient\_Abstract;

use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;

abstract class ProjectClientRelatedException extends RequestRelatedException
{
    /**
     * Package related to this error.
     * 
     * @var ProjectContract
     */
    protected $project;

    /**
     * Constructing exception with appropriated message.
     * 
     * @param ProjectContract
     * @return self
     */
    abstract public static function getException(ProjectContract $project): self;

    /**
     * Setting up project.
     * 
     * @param ProjectContract $project
     * @return self
     */
    public function setProject(ProjectContract $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
    * Exception additional context.
    * 
    * @return array
    */
    public function additionalContext(): array
    {
        return [
            "package" => [
                "name" => $this->project->getVersionedPackage()->getName(),
                "current_version" => $this->project->getVersionedPackage()->getVersion()
            ]
        ];
    }
}