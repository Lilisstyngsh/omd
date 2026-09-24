<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OmdOrderController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\TpsRepairController;
use App\Http\Controllers\MasterDataController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Root
    |--------------------------------------------------------------------------
    */

    Route::get('/', fn() => redirect()->route('dashboard'));


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        return auth()->user()->role === 'user'
            ? app(UserDashboardController::class)->index(request())
            : app(DashboardController::class)->index(request());
    })
        ->middleware('role:omd_leader,omd_member,user')
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | TPS Tool - User
            |--------------------------------------------------------------------------
            */

            Route::get('/tps', [TpsRepairController::class, 'userIndex'])
                ->name('tps.index');

            Route::get('/tps/create', [TpsRepairController::class, 'create'])
                ->name('tps.create');

            Route::post('/tps', [TpsRepairController::class, 'store'])
                ->name('tps.store');

            Route::get('/tps/{order}', [TpsRepairController::class, 'userShow'])
                ->name('tps.show');

            Route::post('/tps/{order}/confirm', [TpsRepairController::class, 'confirm'])
                ->name('tps.confirm');


            /*
            |--------------------------------------------------------------------------
            | Order Repair - User
            |--------------------------------------------------------------------------
            */

            Route::get('/orders', [UserOrderController::class, 'index'])
                ->name('orders.index');

            Route::get('/orders/create', [UserOrderController::class, 'create'])
                ->name('orders.create');

            Route::post('/orders', [UserOrderController::class, 'store'])
                ->name('orders.store');

            Route::get('/orders/{order}', [UserOrderController::class, 'show'])
                ->name('orders.show');

            Route::post('/orders/{order}/confirm', [UserOrderController::class, 'confirm'])
                ->name('orders.confirm');
        });


    /*
    |--------------------------------------------------------------------------
    | OMD Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:omd_member,omd_leader')
        ->prefix('omd')
        ->name('omd.')
        ->group(function () {
            Route::middleware('role:omd_leader')
                ->prefix('users')
                ->name('users.')
                ->group(function () {

                    Route::get('/', [UserManagementController::class, 'index'])
                        ->name('index');

                    Route::get('/create', [UserManagementController::class, 'create'])
                        ->name('create');

                    Route::post('/', [UserManagementController::class, 'store'])
                        ->name('store');

                    Route::get('/{user}/edit', [UserManagementController::class, 'edit'])
                        ->name('edit');

                    Route::put('/{user}', [UserManagementController::class, 'update'])
                        ->name('update');

                    Route::delete('/{user}', [UserManagementController::class, 'destroy'])
                        ->name('destroy');
                });


            /*
            |--------------------------------------------------------------------------
            | Data Master
            |--------------------------------------------------------------------------
            |
            | Hanya OMD yang dapat mengelola:
            | - Model
            | - Produk
            |
            | Scope:
            | - ppic
            | - produksi
            |
            */

            Route::middleware('role:omd_leader')
                ->prefix('master')
                ->name('master.')
                ->group(function () {

                    /*
                    |--------------------------------------------------------------------------
                    | Halaman Data Master
                    |--------------------------------------------------------------------------
                    */

                    Route::get('/{scope}', [MasterDataController::class, 'index'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('index');


                    /*
                    |--------------------------------------------------------------------------
                    | Model
                    |--------------------------------------------------------------------------
                    */

                    // Tambah Model
                    Route::post('/{scope}/model', [MasterDataController::class, 'storeModel'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.store');

                    Route::get('/{scope}/model/{masterModel}/edit', [MasterDataController::class, 'editModel'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.edit');

                    Route::put('/{scope}/model/{masterModel}', [MasterDataController::class, 'updateModel'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.update');

                    Route::delete('/{scope}/model/{masterModel}', [MasterDataController::class, 'destroyModel'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.destroy');


                    /*
                    |--------------------------------------------------------------------------
                    | Produk
                    |--------------------------------------------------------------------------
                    */

                    // Tambah Produk
                    Route::post('/{scope}/product', [MasterDataController::class, 'storeProduct'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.store');

                    // Form Edit Produk
                    Route::get('/{scope}/product/{product}/edit', [MasterDataController::class, 'editProduct'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.edit');

                    // Update Produk
                    Route::put('/{scope}/product/{product}', [MasterDataController::class, 'updateProduct'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.update');

                    // Hapus Produk
                    Route::delete('/{scope}/product/{product}', [MasterDataController::class, 'destroyProduct'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.destroy');


                    /*
                    |--------------------------------------------------------------------------
                    | Export Data Master
                    |--------------------------------------------------------------------------
                    */

                    // Export Excel
                    Route::get('/{scope}/export/excel', [MasterDataController::class, 'exportExcel'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('export.excel');

                    // Export PDF
                    Route::get('/{scope}/export/pdf', [MasterDataController::class, 'exportPdf'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('export.pdf');
                });


            /*
            |--------------------------------------------------------------------------
            | Shortcut Data Master
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/master-ppic',
                fn() =>
                redirect()->route('omd.master.index', [
                    'scope' => 'ppic'
                ])
            )
                ->middleware('role:omd_leader')
                ->name('master.ppic');


            Route::get(
                '/master-produksi',
                fn() =>
                redirect()->route('omd.master.index', [
                    'scope' => 'produksi'
                ])
            )
                ->middleware('role:omd_leader')
                ->name('master.produksi');


            /*
            |--------------------------------------------------------------------------
            | TPS Tool - OMD
            |--------------------------------------------------------------------------
            */

            Route::get('/tps', [TpsRepairController::class, 'omdIndex'])
                ->name('tps.index');

            Route::get('/tps/{order}', [TpsRepairController::class, 'omdShow'])
                ->name('tps.show');

            Route::post('/tps/{order}/leader-check', [TpsRepairController::class, 'leaderCheck'])
                ->name('tps.leader-check');

            Route::post('/tps/{order}/verify', [TpsRepairController::class, 'verify'])
                ->name('tps.verify');

            Route::post('/tps/{order}/schedule', [TpsRepairController::class, 'schedule'])
                ->name('tps.schedule');

            Route::post('/tps/{order}/complete', [TpsRepairController::class, 'complete'])
                ->name('tps.complete');


            /*
            |--------------------------------------------------------------------------
            | Order Repair - OMD
            |--------------------------------------------------------------------------
            */

            Route::get('/orders', [OmdOrderController::class, 'index'])
                ->name('orders.index');

            Route::get('/orders/{order}', [OmdOrderController::class, 'show'])
                ->name('orders.show');

            Route::post('/orders/{order}/verify', [OmdOrderController::class, 'verify'])
                ->name('orders.verify');

            Route::post('/orders/{order}/start-repair', [OmdOrderController::class, 'startRepair'])
                ->name('orders.start');

            Route::post('/orders/{order}/complete', [OmdOrderController::class, 'complete'])
                ->name('orders.complete');


            /*
            |--------------------------------------------------------------------------
            | Recap
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/recap',
                fn() =>
                redirect()->route('dashboard')
            )
                ->name('recap');
        });
});
