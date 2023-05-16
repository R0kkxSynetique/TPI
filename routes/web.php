<?php

use App\Http\Controllers\RcModelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\EngineController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        'user' => 'App\Http\Controllers\UserController',
        'batteries' => 'App\Http\Controllers\BatteryController',
        'engines' => 'App\Http\Controllers\EngineController',
    ]);

    Route::name('user.')->controller(UserController::class)->group(function () {
        Route::get('/image/user/{userId}', 'getUserImage');
        Route::post('/image/user/{userId}', 'updateImage');
        Route::get('user/{userId}/change-password', 'changePassword');
    });

    Route::name('rc-models.')->controller(RcModelController::class)->group(function () {
        Route::get('/', 'index')->name('/');
        Route::post('/image/rcModel/{rcModelId}', 'updateImage');
    });

    Route::name('batteries.')->controller(BatteryController::class)->group(function () {
        Route::get('/batteries', 'index')->name('index');
    });

    Route::name('engines.')->controller(EngineController::class)->group(function () {
        Route::get('/engines', 'index')->name('index');
        Route::get('/image/engine/{engineId}', 'getEngineImage');
    });

    Route::name('qr-codes.')->controller(QRCodeController::class)->group(function () {
        Route::get('/qr-code/{rcModelId}', 'downloadQr')->name('qr-code');
    });
});

Route::name('rc-models.')->controller(RcModelController::class)->group(function () {
    Route::get('/rc-models/{rcModelId}/guest', 'guest')->name('rc-models');
    Route::get('/image/rcModel/{rcModelId}', 'getRcModelImage');
});
