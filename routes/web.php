<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EventController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/empresas', [EmpresasController::class, 'index'])->name('empresas');
    Route::get('/empresas/create', [EmpresasController::class, 'create'])->name('empresas.create');
    Route::get('/empresas/edit/{id}', [EmpresasController::class, 'edit'])->name('empresas.edit');

    Route::get('/service/category', [ServiceController::class, 'index'])->name('service.category');



});
