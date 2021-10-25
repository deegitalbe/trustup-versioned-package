<?php

use Illuminate\Support\Facades\Route;
use Deegitalbe\TrustupVersionedPackage\Http\Controllers\PackageController;

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
*/

// Project package version
Route::get('version', [PackageController::class, 'version'])->name('version');