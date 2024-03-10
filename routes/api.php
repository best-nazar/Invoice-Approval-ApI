<?php

use App\Modules\invoices\Infrastructure\Http\Controllers\InvoicesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/invoice/{id}', [InvoicesController::class, 'show']);

Route::post('/invoice/{id}/approve', [InvoicesController::class, 'approve']);

Route::post('/invoice/{id}/reject', [InvoicesController::class, 'reject']);
