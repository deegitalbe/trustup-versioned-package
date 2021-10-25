<?php
namespace Deegitalbe\TrustupVersionedPackage\Project;

use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\TrustupVersionedPackage\Project\ProjectCredential;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClientContract;
use Deegitalbe\TrustupVersionedPackage\Exceptions\ProjectClient\NoPackageVersionFound;

/**
 * API client able to communicate with application
 * 
 */
class ProjectClient implements ProjectClientContract
{
    /**
     * Application api client.
     * 
     * @var ClientContract
     */
    protected $client;

    /**
     * Application api client.
     * 
     * @var ProjectContract
     */
    protected $project;

    /**
     * This class should be instanciated with static methods.
     */
    public function __construct(ClientContract $client)
    {
        $this->client = $client;
    }

    /**
     * Checking package version for this project.
     * 
     * @return bool|null telling is package is outdated (null if error occured).
     */
    public function checkPackageVersion(): ?bool
    {
        $request = app()->make(RequestContract::class)
            ->setVerb('GET')
            ->addQuery([
                'version' => $this->project->getVersionedPackage()->getVersion(),
                'name' => $this->project->getVersionedPackage()->getName()
            ])
            ->setUrl(Package::prefix() . '/version');
        $response = $this->client->start($request);
        
        if (!$response->ok()):
            return null;
        endif;

        return $response->get()->data->is_outdated;
    }

    /**
     * Construct class based on given project.
     * 
     * @param ProjectContract $project
     * @return self
     */
    public static function forProject(ProjectContract $project): ProjectClientContract
    {
        $client = app()->make(ClientContract::class)
            ->setCredential(ProjectCredential::forProject($project));
        
        return app()->make(ProjectClientContract::class, ['client' => $client])
            ->setProject($project);
    }

    /**
     * Project linked to this client.
     * 
     * @return ProjectContract
     */
    public function getProject(): ProjectContract
    {
        return $this->project;
    }

    /**
     * Setting project linked to this client.
     * 
     * @return ProjectClientContract
     */
    public function setProject(ProjectContract $project): ProjectClientContract
    {
        $this->project = $project;

        return $this;
    }
}