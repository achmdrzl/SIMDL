<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\MasterDataController;
use App\Http\Controllers\Backend\OrderController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::group(['middleware' => ['role:superadmin|admin', 'auth']], function () {

    // DASHBOARD USER
    Route::get('/dashboard', MasterDataController::class . '@index')->name('dashboard.index');

    // MASTER USER
    Route::get('/user', MasterDataController::class . '@userIndex')->name('user.index');
    Route::post('/userStore', MasterDataController::class. '@userStore')->name('user.store');
    Route::post('/userEdit', MasterDataController::class. '@userEdit')->name('user.edit');
    Route::post('/userDestroy', MasterDataController::class. '@userDestroy')->name('user.destroy');
    
    // MASTER CUSTOMER
    Route::get('/customer', MasterDataController::class . '@customerIndex')->name('customer.index');
    Route::post('/userStore', MasterDataController::class. '@userStore')->name('user.store');
    Route::post('/userEdit', MasterDataController::class. '@userEdit')->name('user.edit');
    Route::post('/userDestroy', MasterDataController::class. '@userDestroy')->name('user.destroy');

    // TRANSAKSI ORDER
    Route::get('/order', OrderController::class. '@orderIndex')->name('order.index');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
