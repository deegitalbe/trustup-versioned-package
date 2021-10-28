<?php
namespace Deegitalbe\TrustupVersionedPackage\Exceptions\ProjectClient;

use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;
use Deegitalbe\TrustupVersionedPackage\Exceptions\ProjectClient\_Abstract\ProjectClientRelatedException;

class CheckPackageVersionFailed extends ProjectClientRelatedException
{
    /**
     * Constructing exception with appropriated message.
     * 
     * @param ProjectContract
     * @return self
     */
    public static function getException(ProjectContract $project): self
    {
        return (new self("Checking Package [{$project->getVersionedPackage()->getName()}] version in [{$project->getUrl()}] failed."))
            ->setProject($project);
    }
}