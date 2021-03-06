<?php
namespace Deegitalbe\TrustupVersionedPackage\Project;

use Henrotaym\LaravelHelpers\Facades\Helpers;
use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Deegitalbe\TrustupVersionedPackage\Project\ProjectCredential;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClientContract;
use Deegitalbe\TrustupVersionedPackage\Exceptions\ProjectClient\NoPackageVersionFound;
use Deegitalbe\TrustupVersionedPackage\Exceptions\ProjectClient\GetPackageVersionFailed;
use Deegitalbe\TrustupVersionedPackage\Project\ProjectClient\CheckPackageVersionResponse;
use Deegitalbe\TrustupVersionedPackage\Exceptions\ProjectClient\CheckPackageVersionFailed;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClient\CheckPackageVersionResponseContract;

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
     * @param string $version Version to check. if none given, actual one (in this application) is used.
     * @return CheckPackageVersionResponseContract|null null if error occured.
     */
    public function checkPackageVersion(string $version = null): ?CheckPackageVersionResponseContract
    {
        $request = app()->make(RequestContract::class)
            ->setVerb('GET')
            ->addQuery([
                'version' => $version ?? $this->project->getVersionedPackage()->getVersion()
            ])
            ->setUrl(Package::prefix() . '/packages/' . $this->project->getVersionedPackage()->getName() . '/check');
        
        $trying = $this->client->try($request, CheckPackageVersionFailed::getException($this->project));
        
        if (!$trying->ok()):
            report($trying->error());
            return null;
        endif;

        return app()->make(CheckPackageVersionResponse::class, ['response' => $trying->response()->get()->data]);
    }

    /**
     * Getting package version for this project.
     * 
     * @return string|null null if error occured.
     */
    public function getPackageVersion(): ?string
    {
        $request = app()->make(RequestContract::class)
            ->setVerb('GET')
            ->setUrl(Package::prefix() . '/packages/' . $this->project->getVersionedPackage()->getName());

        $trying = $this->client->try($request, GetPackageVersionFailed::getException($this->project));
        
        if (!$trying->ok()):
            report($trying->error());
            return null;
        endif;

        return $trying->response()->get()
            ->data->version;
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