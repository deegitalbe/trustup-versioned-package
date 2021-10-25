<?php
namespace Deegitalbe\TrustupVersionedPackage\Commands;

use Illuminate\Console\Command;
use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageCheckerContract;

class CheckPackagesVersion extends Command
{
    protected $signature = 'trustup-versioned-packages:check';

    protected $description = 'Checking if any package is outdated somewhere in our projects.';

    public function handle(VersionedPackageCheckerContract $checker)
    {
        $checker->getPackages()->each([$this, 'checkPackage']);
    }

    public function checkPackage(VersionedPackageContract $package)
    {
        $this->line("Checking package {$package->getName()}...");
        $package->getProjects()->each([$this, 'checkProject']);
    }

    /**
     * Checking project package version.
     * 
     * @param ProjectContract $project
     * @return void
     */
    public function checkProject(ProjectContract $project)
    {
        $this->line("Checking {$project->getUrl()}...");
        $is_outdated = $project->getProjectClient()->checkPackageVersion();

        // Error
        if (is_null($is_outdated)):
            $this->error("Could not reach {$project->getUrl()} concerning {$project->getVersionedPackage()->getName()}");
            return;
        endif;

        // Outdated
        if ($is_outdated):
            $this->error("{$project->getUrl()} is outdated. Please update to version {$project->getVersionedPackage()->getVersion()}");
            return;
        endif;

        // Up-to-date
        $this->info("[{$project->getUrl()}] is up-to-date.");
    }
}