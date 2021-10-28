<?php
namespace Deegitalbe\TrustupVersionedPackage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Deegitalbe\TrustupVersionedPackage\Facades\Package;
use Deegitalbe\TrustupVersionedPackage\Http\Resources\VersionedPackage;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageCheckerContract;
use Deegitalbe\TrustupVersionedPackage\Exceptions\Package\VersionedPackageOutdated;
use Deegitalbe\TrustupVersionedPackage\Exceptions\Package\NoPackageMatchingGivenName;

class VersionedPackageController extends Controller
{
    /**
     * Checking requested package version.
     * 
     * @param Request $request
     */
    public function check(Request $request)
    {
        $data = $request->validate(['version' => 'required|string']);
        ['version' => $version] = $data;
        
        // If version is outdated, write a log
        if ($version > $request->package->getVersion()):
            report(
                VersionedPackageOutdated::getException($package)
                    ->setNewVersion($version)
            );

            return response([
                'data' =>[
                    'is_outdated' => true,
                    'new_version' => $version,
                    'package' => new VersionedPackage($request->package)
                ]
            ]);
        endif;

        return response([
            'data' => [
                'is_outdated' => false, 
                'package' => new VersionedPackage($request->package)
            ]
        ]);
    }

    /**
     * Checking requested package version.
     * 
     * @param Request $request
     */
    public function show(Request $request)
    {
        return new VersionedPackage($request->package);
    }
}