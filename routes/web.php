<?php

use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AdminUserController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('menu', MenuController::class);
        Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
        
        Route::resource('kategori', KategoriController::class);
        Route::resource('user', UserController::class);
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::resource('user', UserController::class);
        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        
        Route::get('/detail-pesanan/{id_pesanan}', [PesananController::class, 'detail_pesanan_admin'])
            ->name('pesanan.detail_pesanan_admin');


        Route::get('/pesanan/{pesanan}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
        Route::put('/pesanan/{pesanan}', [PesananController::class, 'update'])->name('pesanan.update');
        Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroy'])->name('pesanan.destroy');

        Route::get('/admin/pesanan/detail/{id_detail_pesanan}/edit', [PesananController::class, 'editItem'])->name('pesanan.detail.edit');
        Route::put('/admin/pesanan/detail/{id_detail_pesanan}', [PesananController::class, 'updateItem'])->name('pesanan.detail.update');
        Route::delete('/pesanan/{pesanan}/item/{detailPesanan}',[PesananController::class, 'destroyItem'])->name('pesanan.item.destroy');
        
        Route::get('/pesanan/{pesanan}/item/create', [PesananController::class, 'createItem'])
            ->name('pesanan.item.create');
        Route::post('/pesanan/{pesanan}/item', [PesananController::class, 'storeItem'])
            ->name('pesanan.item.store');

        


    });
    // ->get('/admin', fn () => 'ADMIN OK');



    Route::middleware(['auth', 'role:user'])
    // ->prefix('kasir')
    ->group(function () {

        Route::get('/kasir', action: [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/', [KasirController::class, 'store'])->name('kasir.store');
        Route::post('/cart/{id_menu}/kurangi', [KasirController::class, 'kurangiItem'])
            ->name('kasir.kurangiItem');
        Route::get('/transaction-history', [KasirController::class, 'transactionhistory'])->name('kasir.transactionhistory');


        Route::get('/pesanan/{id_pesanan}', [TransactionHistoryController::class, 'show'])->name('transactionhistory.show');
        Route::resource('pesanan', PesananController::class);

        Route::get('/transactionhistory/{id}/struk', [TransactionHistoryController::class, 'struk'])->name('transactionhistory.struk');


    });

});


// 🔥 INI YANG KURANG SELAMA INI
require __DIR__.'/auth.php';
