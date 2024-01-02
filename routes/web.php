<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    PlanController,
    UserController,
    DetailPlanController
};
use App\Http\Controllers\ACL\{
    ProfileController,
    PermissionController,
    PlanProfileController,
    ProfilePermissionController
};
use App\Http\Controllers\Site\{
    SiteController
};

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {

        /**
         * Routes Users
         */
        Route::any('users/search', [UserController::class, 'search'])->name('users.search');
        Route::resource('users', UserController::class);

        /**
         * Plan x Profile
         */
        Route::get('plans/{id}/profiles/{idProfile}/detach', [PlanProfileController::class, 'detachProfilesPlan'])->name('profiles.plans.detach');
        Route::post('plans/{id}/profiles', [PlanProfileController::class, 'attachProfilesPlan'])->name('profiles.plans.attach');
        Route::any('plans/{id}/profiles/create', [PlanProfileController::class, 'profilesAvailable'])->name('plans.profiles.available');
        Route::get('plans/{id}/profiles', [PlanProfileController::class, 'profiles'])->name('plans.profiles');
        Route::get('profiles/{id}/plans', [PlanProfileController::class, 'plans'])->name('profiles.plans');

        /**
         * Profiles x Permissions
         */
        Route::get('profiles/{id}/permission/{idPermission}/detach', [ProfilePermissionController::class, 'detachPermissionsProfile'])->name('profiles.permissions.detach');
        Route::post('profiles/{id}/permissions', [ProfilePermissionController::class, 'attachPermissionsProfile'])->name('profiles.permissions.attach');
        Route::any('profiles/{id}/permissions/create', [ProfilePermissionController::class, 'permissionsAvailable'])->name('profiles.permissions.available');
        Route::get('profiles/{id}/permissions', [ProfilePermissionController::class, 'permissions'])->name('profiles.permissions');
        Route::get('permissions/{id}/profiles', [ProfilePermissionController::class, 'profiles'])->name('permissions.profiles');

        /**
         * Routes Permissions
         */
        Route::any('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');
        Route::resource('permissions', PermissionController::class);

        /**
         * Routes Profiles
         */
        Route::any('profiles/search', [ProfileController::class, 'search'])->name('profiles.search');
        Route::resource('profiles', ProfileController::class);

        /**
         * Routes Details Plans
         */
        Route::delete('plans/{url}/details/{idDetail}', [DetailPlanController::class, 'destroy'])->name('details.plans.destroy');
        Route::get('plans/{url}/details/create', [DetailPlanController::class, 'create'])->name('details.plans.create');
        Route::get('plans/{url}/details/{idDetail}', [DetailPlanController::class, 'show'])->name('details.plans.show');
        Route::put('plans/{url}/details/{idDetail}', [DetailPlanController::class, 'update'])->name('details.plans.update');
        Route::get('plans/{url}/details/{idDetail}/edit', [DetailPlanController::class, 'edit'])->name('details.plans.edit');
        Route::post('plans/{url}/details', [DetailPlanController::class, 'store'])->name('details.plans.store');
        Route::get('plans/{url}/details', [DetailPlanController::class, 'index'])->name('details.plans.index');


        /**
         * Routes Plans
         */
        Route::any('plans/search', [PlanController::class, 'search'])->name('plans.search');
        Route::resource('plans', PlanController::class);
        // Route::get('plans/create', [PlanController::class, 'create'])->name('plans.create');
        // Route::put('plans/{url}', [PlanController::class, 'update'])->name('plans.update');
        // Route::get('plans/{url}/edit', [PlanController::class, 'edit'])->name('plans.edit');
        // Route::delete('plans/{url}', [PlanController::class, 'destroy'])->name('plans.destroy');
        // Route::get('plans/{url}', [PlanController::class, 'show'])->name('plans.show');
        // Route::post('plans', [PlanController::class, 'store'])->name('plans.store');
        // Route::get('plans', [PlanController::class, 'index'])->name('plans.index');

        /**
         * Home Dashboard
         */
        Route::get('/', [PlanController::class, 'index'])->name('admin.index');
    });



/**
 * Site
 */
Route::get('/plan/{url}', [SiteController::class, 'plan'])->name('plan.subscription');
Route::get('/', [SiteController::class, 'index'])->name('site.home');

/**
 * Auth Routes
 */
Auth::routes();
