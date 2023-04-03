<?php

use App\Http\Controllers\LembarTemuanController;
use App\Http\Controllers\TemuanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

$role = '';
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('admin')
->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('/user', UserController::class);
    Route::group(['prefix' => 'temuan', 'as' => 'temuan.'], function() {
        Route::get('/', [TemuanController::class, 'index'])->name('index');
        Route::post('/dataTable', [TemuanController::class, 'dataTable'])->name('dataTable');
        Route::get('/create', [TemuanController::class, 'create'])->name('create');
        Route::post('/store', [TemuanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TemuanController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [TemuanController::class, 'update'])->name('update');
        Route::get('/{id}/lembar-temuan', [LembarTemuanController::class, 'create'])->name('lembar-temuan.create');
        Route::put('/{id}/lembar-temuan/update', [LembarTemuanController::class, 'updateTemuan'])->name('lembar-temuan.update');
    });

});
