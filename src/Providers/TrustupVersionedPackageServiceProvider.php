<?php
namespace Deegitalbe\TrustupVersionedPackage\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Deegitalbe\TrustupVersionedPackage\Project\Project;
use Deegitalbe\TrustupVersionedPackage\Project\ProjectClient;
use Deegitalbe\TrustupVersionedPackage\VersionedPackageChecker;
use Deegitalbe\TrustupVersionedPackage\Commands\CheckPackagesVersion;
use Deegitalbe\TrustupVersionedPackage\Package as UnderlyingPackage;
use Deegitalbe\TrustupVersionedPackage\Contracts\Models\AccountContract;
use Deegitalbe\TrustupVersionedPackage\Http\Middleware\AuthorizedServer;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectClientContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageCheckerContract;

class TrustupVersionedPackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this
            // ->registerConfig()
            ->bindFacade()
            ->bindPackageChecker()
            ->bindProjects();        
    }

    public function boot()
    {
        $this
            // ->makeConfigPublishable()
            ->registerPackageCommands()
            ->loadRoutes();
    }

    protected function loadRoutes(): self
    {
        Route::group([
            'prefix' => Package::prefix(),
            'name' => Package::prefix() . ".",
            'middleware' => AuthorizedServer::class
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        });

        return $this;
    }

    // protected function registerConfig(): self
    // {
    //     $this->mergeConfigFrom($this->getConfigPath(), 'trustup-pro-admin-common');

    //     return $this;
    // }

    protected function registerPackageCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckPackagesVersion::class,
            ]);
        }

        return $this;
    }

    protected function bindFacade(): self
    {
        $this->app->bind('trustup-versioned-package', function($app) {
            return new UnderlyingPackage();
        });

        return $this;
    }

    protected function bindPackageChecker(): self
    {
        $this->app->singleton(VersionedPackageCheckerContract::class, function($app) {
            return new VersionedPackageChecker();
        });

        return $this;
    }

    protected function bindProjects(): self
    {
        $this->app->bind(ProjectContract::class, Project::class);
        $this->app->bind(ProjectClientContract::class, ProjectClient::class);
        
        return $this;
    }

    // protected function makeConfigPublishable(): self
    // {
    //     if ($this->app->runningInConsole()):
    //         $this->publishes([
    //           $this->getConfigPath() => config_path('trustup-pro-admin-common.php'),
    //         ], 'config');
    //     endif;

    //     return $this;
    // }

    // protected function getConfigPath(): string
    // {
    //     return __DIR__.'/../config/config.php';
    // }
}