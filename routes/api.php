<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(ContactController::class)->group(function () {
    Route::get('contact/filter', 'filter');
    Route::get('contact/{id}', 'show');
    Route::post('contact', 'store');
    Route::put('contact/{id}', 'update');
    Route::delete('contact/{id}', 'destroy');
});
