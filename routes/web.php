<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SuAdmin\DashboardController;
use App\Http\Controllers\SuAdmin\DataMenaraController;
use App\Http\Controllers\SuAdmin\RegulasiController;
use App\Http\Controllers\SuAdmin\HotspotController as AdminHotspotController;
use App\Http\Controllers\SuAdmin\UserManagementController;
use App\Http\Controllers\SuAdmin\DataBaktiController;
use App\Http\Controllers\SuAdmin\BlankspotController as AdminBlankspotController;


// --- Rute Halaman Publik ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/chart-data', [HomeController::class, 'getChartData'])->name('chart.data');

// Rute Data Menara
Route::get('/datamenara', [HomeController::class, 'dataMenara'])->name('datamenara');
Route::get('/datamenara/pdf', [HomeController::class, 'generateMenaraPDF'])->name('datamenara.pdf');

// Rute Data Bakti (Dari Kode Anda)
Route::get('/databakti', [HomeController::class, 'dataBakti'])->name('databakti');
Route::get('/databakti/pdf', [HomeController::class, 'generateBaktiPDF'])->name('databakti.pdf');
// Rute Regulasi
Route::get('/regulasi', [HomeController::class, 'regulasi'])->name('regulasi');
Route::get('/regulasi/{regulasi}/view', [HomeController::class, 'trackRegulasiView'])->name('regulasi.view.public');
Route::get('/regulasi/{regulasi}/download', [HomeController::class, 'trackRegulasiDownload'])->name('regulasi.download.public');

// Rute Hotspot
Route::get('/hotspot', [HotspotController::class, 'index'])->name('hotspot.index');
Route::get('/hotspot/autocomplete', [HotspotController::class, 'autocomplete'])->name('hotspot.autocomplete');
Route::get('/hotspot/pdf', [HotspotController::class, 'generatePDF'])->name('hotspot.pdf');

// Rute Peta
Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
Route::get('/peta/menara-data', [PetaController::class, 'getMenaraData'])->name('peta.menara_data');

// Rute Blankspot (Dari Kode Teman Anda)
Route::get('/blankspot', [HomeController::class, 'blankspot'])->name('blankspot.index');
Route::get('/blankspot/pdf', [HomeController::class, 'generateBlankspotPDF'])->name('blankspot.pdf');


// --- Rute Autentikasi ---
Route::get('/panel', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/panel', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// --- Rute Admin ---
Route::middleware(['is_admin'])->prefix('suadmin')->name('suadmin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-rencana', [DashboardController::class, 'updateRencana'])->name('dashboard.update_rencana'); // Dari Teman Anda


    // --- Data Menara ---
    Route::get('/datamenara/pdf', [DataMenaraController::class, 'generatePDF'])->name('datamenara.pdf');
    Route::post('/datamenara/import', [DataMenaraController::class, 'importExcel'])->name('datamenara.import');
    Route::resource('datamenara', DataMenaraController::class);


    // --- Data Bakti (Dari Kode Anda) ---
    Route::get('/databakti/pdf', [DataBaktiController::class, 'generatePDF'])->name('databakti.pdf');
    Route::post('/databakti/import', [DataBaktiController::class, 'import'])->name('databakti.import'); // <-- TAMBAHKAN INI
    Route::resource('databakti', DataBaktiController::class);


    // --- Regulasi ---
    Route::get('/regulasi/{regulasi}/download', [RegulasiController::class, 'trackDownload'])->name('regulasi.download');
    Route::resource('regulasi', RegulasiController::class);


    // --- Hotspot ---
    Route::get('/hotspot/pdf', [AdminHotspotController::class, 'generatePDF'])->name('hotspot.pdf');
    Route::get('/hotspot/import', [AdminHotspotController::class, 'showImportForm'])->name('hotspot.import.form');
    Route::post('/hotspot/import', [AdminHotspotController::class, 'handleImport'])->name('hotspot.import.handle');
    Route::resource('hotspot', AdminHotspotController::class);


    // --- Users ---
    Route::resource('users', UserManagementController::class)->middleware('is_superadmin');


    // --- Blankspot (Dari Kode Teman Anda) ---
    Route::get('/blankspot/pdf', [AdminBlankspotController::class, 'generatePDF'])->name('blankspot.pdf');
    Route::post('/blankspot/import', [AdminBlankspotController::class, 'handleImport'])->name('blankspot.import.handle');
    Route::resource('blankspot', AdminBlankspotController::class);

});
