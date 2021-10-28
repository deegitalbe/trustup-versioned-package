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
        $this->line("Checking package [{$package->getName()}]...");
        $projects = $package->getProjects();
        // Getting max package version
        $max_version = $projects->reduce(function(string $max_version, ProjectContract $project) {
            $version = $project->getProjectClient()->getPackageVersion();
            return max([$version, $max_version]);
        }, $package->getVersion());
        $this->line("Up-to-date version is [{$max_version}].");

        // If package is outdated in this application, write a log
        if ($max_version > $package->getVersion()):
            report(
                VersionedPackageOutdated::getException($package)
                    ->setNewVersion($version)
            );
            $this->line("This project is outdated. Please update from [{$package->getVersion()}] to [{$max_version}].");
        else:
            $this->line("This project is up-to-date.");
        endif;
        
        // Check every projects compared to max version
        $package->getProjects()->each(function(ProjectContract $project) use ($max_version) {
            $this->checkProject($project, $max_version);
        });
    }

    /**
     * Checking project package version.
     * 
     * @param ProjectContract $project
     * @param string $version
     * @return void
     */
    public function checkProject(ProjectContract $project, string $version)
    {
        $this->line("Checking [{$project->getUrl()}]...");
        $check_response = $project->getProjectClient()->checkPackageVersion($version);

        // Error
        if (is_null($check_response)):
            $this->error("Could not reach [{$project->getUrl()}] concerning [{$project->getVersionedPackage()->getName()}].");
            return;
        endif;

        // Outdated
        if ($check_response->isOutdated()):
            $this->error("[{$project->getUrl()}] is outdated. Please update from [{$check_response->getPackageVersion()}] to [{$version}].");
            return;
        endif;

        // Up-to-date
        $this->info("[{$project->getUrl()}] is up-to-date.");
    }
}