<?php

use App\Http\Controllers\RcModelController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ! The Auth routes are defined in the FortifyServiceProvider

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resources([
        'rc-models' => 'App\Http\Controllers\RcModelController',
    ]);

    Route::name('user.settings.')->controller(UserController::class)->group(function () {
        Route::get('/user/settings', 'index')->name('index');
        Route::get('/image/user/{userId}', 'getUserImage');
        Route::post('/image/user/{userId}', 'updateImage');
        Route::put('/user/{user}/settings', 'update');
    });

    Route::name('rc-models.')->controller(RcModelController::class)->group(function () {
        Route::get('/', 'index')->name('/');
        Route::get('/image/rcModel/{rcModelId}', 'getRcModelImage');
        Route::post('/image/rcModel/{rcModelId}', 'updateImage');
    });
});
