<?php

use App\Http\Controllers\Panel\LocationController;
use App\Http\Controllers\Site\IndexController;
use App\Http\Controllers\Site\MapController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [IndexController::class, 'index']);
Route::post('/', [MapController::class, 'store']);



Route::prefix('panel')->middleware(['web', 'auth:admin', 'permission'])->as('panel.')->group(function () {
    Route::resource('locations', LocationController::class)->only('index');
    Route::put('locations/{location}/update/status', [LocationController::class, 'updateStatus'])->name('locations.update.status');
});
