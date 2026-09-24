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
| Hanya OMD Leader yang dapat mengelola Data Master.
|
| Struktur:
|
| Scope
|   └── Plant
|       └── Area / Line
|           └── Model
|               └── Produk
|
*/

            Route::middleware('role:omd_leader')
                ->prefix('master')
                ->name('master.')
                ->group(function () {

                    /*
        |--------------------------------------------------------------------------
        | Halaman Data Master - Plant
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | /omd/master/ppic
        | /omd/master/produksi
        |
        */

                    Route::get('/{scope}', [MasterDataController::class, 'index'])
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('index');


                    /*
        |--------------------------------------------------------------------------
        | Plant
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | /omd/master/ppic/plant/{plant}
        |
        | Menampilkan Area / Line berdasarkan Plant.
        |
        */

                    Route::get(
                        '/{scope}/plant/{plant}',
                        [MasterDataController::class, 'plant']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('plant.index');


                    /*
        |--------------------------------------------------------------------------
        | Tambah Plant
        |--------------------------------------------------------------------------
        |
        | Plant dibuat berdasarkan scope yang sedang dibuka.
        |
        */

                    Route::post(
                        '/{scope}/plant',
                        [MasterDataController::class, 'storePlant']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('plant.store');


                    /*
        |--------------------------------------------------------------------------
        | Area / Line
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | /omd/master/ppic/plant/1/area/1
        |
        | Menampilkan Model dan Produk berdasarkan Area.
        |
        */

                    Route::get(
                        '/{scope}/plant/{plant}/area/{area}',
                        [MasterDataController::class, 'area']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('area.index');


                    /*
        |--------------------------------------------------------------------------
        | Model
        |--------------------------------------------------------------------------
        |
        | Model dibuat berdasarkan:
        |
        | Scope
        | Plant
        | Area
        |
        */

                    Route::post(
                        '/{scope}/plant/{plant}/area/{area}/model',
                        [MasterDataController::class, 'storeModel']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.store');


                    Route::get(
                        '/{scope}/plant/{plant}/area/{area}/model/{masterModel}/edit',
                        [MasterDataController::class, 'editModel']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.edit');


                    Route::put(
                        '/{scope}/plant/{plant}/area/{area}/model/{masterModel}',
                        [MasterDataController::class, 'updateModel']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.update');


                    Route::delete(
                        '/{scope}/plant/{plant}/area/{area}/model/{masterModel}',
                        [MasterDataController::class, 'destroyModel']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('model.destroy');


                    /*
        |--------------------------------------------------------------------------
        | Produk
        |--------------------------------------------------------------------------
        |
        | Produk dibuat di dalam konteks:
        |
        | Scope
        | Plant
        | Area
        | Model
        |
        */

                    Route::post(
                        '/{scope}/plant/{plant}/area/{area}/product',
                        [MasterDataController::class, 'storeProduct']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.store');


                    Route::get(
                        '/{scope}/plant/{plant}/area/{area}/product/{product}/edit',
                        [MasterDataController::class, 'editProduct']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.edit');


                    Route::put(
                        '/{scope}/plant/{plant}/area/{area}/product/{product}',
                        [MasterDataController::class, 'updateProduct']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.update');


                    Route::delete(
                        '/{scope}/plant/{plant}/area/{area}/product/{product}',
                        [MasterDataController::class, 'destroyProduct']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('product.destroy');


                    /*
        |--------------------------------------------------------------------------
        | Export Data Master
        |--------------------------------------------------------------------------
        */

                    Route::get(
                        '/{scope}/export/excel',
                        [MasterDataController::class, 'exportExcel']
                    )
                        ->whereIn('scope', ['ppic', 'produksi'])
                        ->name('export.excel');


                    Route::get(
                        '/{scope}/export/pdf',
                        [MasterDataController::class, 'exportPdf']
                    )
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
