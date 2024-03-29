<?php

use App\Http\Controllers\Backend\LaporanController;
use App\Http\Controllers\Backend\ManifestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\MasterDataController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PengeluaranController;
use App\Models\Manifest;
use App\Models\Order;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;
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
    Route::get('/dashboardFilter', MasterDataController::class . '@filter')->name('dashboard.filter');
    Route::get('/dashboardResetFilter', MasterDataController::class . '@resetFilter')->name('dashboard.reset.filter');

    // MASTER USER
    Route::get('/user', MasterDataController::class . '@userIndex')->name('user.index');
    Route::post('/userStore', MasterDataController::class . '@userStore')->name('user.store');
    Route::post('/userEdit', MasterDataController::class . '@userEdit')->name('user.edit');
    Route::post('/userDestroy', MasterDataController::class . '@userDestroy')->name('user.destroy');

    // TRANSAKSI ORDER
    Route::get('/order', OrderController::class . '@orderIndex')->name('order.index');
    Route::post('/orderStore', OrderController::class . '@orderStore')->name('order.store');
    Route::get('/paymentorder', OrderController::class . '@validatePaymentIndex')->name('order.payment.index');
    Route::post('/orderDetail', OrderController::class . '@orderDetail')->name('order.detail');
    Route::get('/download/image/{order_id}', OrderController::class . '@downloadBukti')->name('download.bukti');
    Route::post('/loadOrderSelected', OrderController::class . '@loadOrderSelected')->name('load.orderSelected');
    Route::post('/orderValidateStore', OrderController::class . '@orderValidateStore')->name('order.validate.store');
    Route::get('/orderTotal', OrderController::class . '@orderTotal')->name('order.total');
    Route::get('/orderPrint', OrderController::class . '@orderPrint')->name('order.print');
    Route::post('/orderReceive', OrderController::class . '@orderReceive')->name('order.receive');
    Route::post('/orderEdit', OrderController::class . '@orderEdit')->name('order.edit');
    Route::post('/orderDelete', OrderController::class . '@orderDelete')->name('order.delete');
    Route::post('/orderCancel', OrderController::class. '@orderCancel')->name('order.cancel');

    // INPUT HISTORY
    Route::get('/inputHistory', OrderController::class . '@getInput')->name('get.input');
    Route::post('/inputStore', OrderController::class . '@storeInput')->name('store.input');

    // TRANSAKSI MANIFEST
    Route::get('/manifest', ManifestController::class . '@manifestIndex')->name('manifest.index');
    Route::post('/getoderdata', ManifestController::class . '@getorderdata')->name('get.order.data');
    Route::post('/manifestStore', ManifestController::class . '@manifestStore')->name('manifest.store');
    Route::post('/manifestDetail', ManifestController::class . '@manifestDetail')->name('manifest.detail');
    Route::post('/manifestUpdateStatus', ManifestController::class . '@manifestUpdateStatus')->name('manifest.update.status');
    Route::get('/manifestPrint', ManifestController::class . '@manifestPrint')->name('manifest.print');
    Route::post('/getdata', ManifestController::class . '@getdata')->name('get.data');
    Route::post('/manifestDestroy', ManifestController::class . '@manifestDestroy')->name('manifest.destroy');

    // PENGELUARAN MAKASSAR
    Route::get('/pengeluaran', PengeluaranController::class . '@pengeluaranIndex')->name('pengeluaran.index');
    Route::post('/pengeluaranStore', PengeluaranController::class . '@pengeluaranStore')->name('pengeluaran.store');
    Route::post('/pengeluaranDetail', PengeluaranController::class . '@pengeluaranDetail')->name('pengeluaran.detail');
    Route::post('/pengeluaranGetData', PengeluaranController::class . '@getPengeluaranData')->name('pengeluaran.get.data');
    Route::get('/pengeluaranPrint', PengeluaranController::class . '@pengeluaranPrint')->name('pengeluaran.print');
    Route::post('/pengeluaranDestroy', PengeluaranController::class . '@pengeluaranDestory')->name('pengeluaran.destroy');

    // LAPORAN
    Route::get('/laporan', LaporanController::class . '@laporanIndex')->name('laporan.index');
    Route::post('/laporanStore', LaporanController::class . '@laporanStore')->name('laporan.store');
    Route::post('/laporanoderdata', LaporanController::class . '@laporanorderdata')->name('laporan.order.data');
    Route::post('/laporanDetail', LaporanController::class . '@laporanDetail')->name('laporan.detail');
    // Route::get('/downloadBuktiPengeluaran/{objek_id}', LaporanController::class . '@downloadBuktiPengeluaran')->name('download.bukti.pengeluaran');
    Route::get('/downloadBuktiPengeluaranGaji/{objek_id}', LaporanController::class . '@downloadBuktiPengeluaranGaji')->name('download.bukti.pengeluarangaji');
    Route::get('/downloadBuktiPengeluaranTransportasi/{objek_id}', LaporanController::class . '@downloadBuktiPengeluaranTransportasi')->name('download.bukti.pengeluarantransportasi');
    Route::get('/downloadBuktiPengeluaranOperasional/{objek_id}', LaporanController::class . '@downloadBuktiPengeluaranOperasional')->name('download.bukti.pengeluaranoperasional');
    Route::get('/laporanPrint', LaporanController::class . '@laporanPrint')->name('laporan.print');
    Route::post('/laporanDestroy', LaporanController::class . '@laporanDestroy')->name('laporan.destroy');
});

Route::get('/cekRelasi', function () {
    return view('layout-print.suratJalan');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
