<?php
namespace Deegitalbe\TrustupVersionedPackage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageCheckerContract;
use Deegitalbe\TrustupVersionedPackage\Exceptions\Package\NoPackageMatchingGivenName;

class VersionedPackageRelated
{
    /**
     * Package checker.
     * 
     * @var VersionedPackageCheckerContract
     */
    protected $checker;

    /**
     * Constructing class.
     * 
     * @param VersionedPackageCheckerContract $checker
     * @return void
     */
    public function __construct(VersionedPackageCheckerContract $checker)
    {
        $this->checker = $checker;
    }

    /**
     * Handling incoming request.
     * 
     * @param Request $request
     * @param Closure $next
     */
    public function handle(Request $request, Closure $next)
    {
        $package_name = $request->route()->parameter('package');
        $package = $this->checker->findPackage($package_name);

        // If no package foudn => write a log and return a 404.
        if (!$package) {
            report(
                (new NoPackageMatchingGivenName())
                    ->setName($package_name)
            );
            return response(['data' => [
                'message' => "Package [$package_name] not found."
            ]], 404);
        }

        return $next(
            $request->merge([
                'package' => $package
            ])
        );
    }
}