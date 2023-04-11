<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\LembarTemuanController;
use App\Http\Controllers\TindakLanjutController;
use App\Models\Temuan;
use App\Models\User;

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
        $pengguna = User::select('id')->count();
        $temuan = Temuan::select('id', 'hakim_pengawas_bidang','penanggung_jawab_tindak_lanjut','status');
        if(Auth::user()->role == 2)
            $temuan->where('hakim_pengawas_bidang', Auth::user()->id);
        else if(Auth::user()->role == 3)
            $temuan->where('penanggung_jawab_tindak_lanjut', Auth::user()->jabatan);
        $temuan = $temuan->get();
        $belum_tindak = $temuan->where('status', 1)->count();
        $sudah_tindak = $temuan->where('status', 2)->count();
        return view('dashboard', compact('pengguna','temuan', 'belum_tindak', 'sudah_tindak'));
    })->name('dashboard');

    Route::resource('/user', UserController::class);
    Route::get('/user/list/user', [UserController::class, 'list'])->name('user.list');
    Route::group(['prefix' => 'temuan', 'as' => 'temuan.'], function() {
        Route::post('/send-email/{id}', [TemuanController::class, 'sendEmail'])->name('send-email');
        Route::get('/', [TemuanController::class, 'index'])->name('index');
        Route::post('/dataTable', [TemuanController::class, 'dataTable'])->name('dataTable');
        Route::get('/create', [TemuanController::class, 'create'])->name('create');
        Route::post('/store', [TemuanController::class, 'store'])->name('store');
        Route::delete('/{id}', [TemuanController::class, 'destroy'])->name('destory');
        Route::get('/{id}/edit', [TemuanController::class, 'edit'])->name('edit');
        Route::get('/{id}/export-pdf', [TemuanController::class, 'exportPDF'])->name('exportPDF');
        Route::put('/{id}/update', [TemuanController::class, 'update'])->name('update');
        Route::get('/{id}/lembar-temuan', [LembarTemuanController::class, 'create'])->name('lembar-temuan.create');
        Route::put('/{id}/lembar-temuan/update', [LembarTemuanController::class, 'updateTemuan'])->name('lembar-temuan.update');
    });
    Route::group(['prefix' => 'tindak-lanjut', 'as' => 'tindak-lanjut.'], function() {
        Route::get('/', [TindakLanjutController::class, 'index'])->name('index');
        Route::get('/{id}/temuan', [TindakLanjutController::class, 'temuan'])->name('temuan');
        Route::put('/{id}/tindak-lanjut', [TindakLanjutController::class, 'update'])->name('update');
        Route::post('/dataTable', [TindakLanjutController::class, 'dataTable'])->name('dataTable');
        Route::post('/send-email/{id}', [TindakLanjutController::class, 'sendEmail'])->name('send-email');
    });

});
