<?php

use Illuminate\Support\Facades\Route;
use Deegitalbe\TrustupVersionedPackage\Http\Middleware\VersionedPackageRelated;
use Deegitalbe\TrustupVersionedPackage\Http\Controllers\VersionedPackageController;

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
*/

// Project package version

Route::prefix('packages')->name('packages.')->group(function() {
    Route::prefix('{package}')->middleware(VersionedPackageRelated::class)->group(function() {
        Route::get('/', [VersionedPackageController::class, 'show'])->name('show');
        Route::get('check', [VersionedPackageController::class, 'check'])->name('check');
    });
});