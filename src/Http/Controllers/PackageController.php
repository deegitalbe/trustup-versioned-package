<?php
namespace Deegitalbe\TrustupVersionedPackage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageCheckerContract;
use Deegitalbe\TrustupVersionedPackage\Exceptions\Package\VersionedPackageOutdated;
use Deegitalbe\TrustupVersionedPackage\Exceptions\Package\NoPackageMatchingGivenName;

class PackageController extends Controller
{
    /**
     * Checking requested package version.
     * 
     */
    public function version(Request $request, VersionedPackageCheckerContract $checker)
    {
        $data = $request->validate([
            'version' => 'required|string',
            'name' => 'required|string'
        ]);
        ['version' => $version, 'name' => $name] = $data;

        $package = $checker->findPackage($name);

        // If no package foudn => write a log
        if (!$package) {
            report(
                (new NoPackageMatchingGivenName())
                    ->setName($name)
            );
            return response(['data' => null], 404);
        }
        
        // If version is outdated, write a log
        if ($version > $package->getVersion()):
            report(
                VersionedPackageOutdated::getException($package)
                    ->setNewVersion($version)
            );

            return response([
                'data' =>[
                    'is_outdated' => true,
                    'new_version' => $version
                ]
            ]);
        endif;

        return response(['data' => ['is_outdated' => false]]);
    }
}