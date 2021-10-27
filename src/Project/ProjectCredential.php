<?php
namespace Deegitalbe\TrustupVersionedPackage\Project;

use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\Models\AppContract;
use Deegitalbe\ServerAuthorization\Credential\AuthorizedServerCredential;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;

/**
 * This credential is used for authenticating requests between our projects using this package.
 */
class ProjectCredential extends AuthorizedServerCredential
{
    /**
     * Project linked to this credential.
     * 
     * @var ProjectContract
     */
    protected $project;

    /**
     * This class should be instanciated with static methods.
     */
    public function __construct(ProjectContract $project)
    {
        $this->project = $project;
    }

    /**
     * Construct class based on given project url.
     * 
     * @param AppContract $app
     * @return self
     */
    public static function forProject(ProjectContract $project): self
    {
       return app()->make(self::class, ['project' => $project]);
    }

    /**
     * Preparing request.
     */
    public function prepare(RequestContract &$request)
    {
        parent::prepare($request);
        $request->setBaseUrl($this->project->getUrl());
    }
}