<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MateriEdukasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Supplier\DesignTemplateController;
use App\Http\Controllers\UKM\SupplierController;
use App\Http\Controllers\Ukm\TemplateViewerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/about', function () {return view('about');})->name('about');
Route::get('/contact', function () {return view('contact');})->name('contact');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Akses route untuk update profile masing-masing route
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Akses route untuk masing-masing role ke halaman dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/ukm/dashboard', fn() => view('ukm.dashboard'))->name('ukm.dashboard');
    Route::get('/supplier/dashboard', fn() => view('supplier.dashboard'))->name('supplier.dashboard');
    Route::get('/pengguna/dashboard', fn() => view('pengguna.dashboard'))->name('pengguna.dashboard');
});

// Akses route untuk role 'Pengguna' dan 'UKM'
Route::middleware(['auth'])->group(function () {
    Route::get('/materi-edukasi', [MateriEdukasiController::class, 'index'])->name('materi.edukasi');
    Route::get('/materi-edukasi/{id}', [MateriEdukasiController::class, 'show'])->name('materi.edukasi.detail');
    Route::get('/ukm/informasi-supplier', [SupplierController::class, 'index'])->name('ukm.supplier');
    Route::get('/templates', [TemplateViewerController::class, 'index'])->name('templates.index');
    Route::get('/templates/{id}', [TemplateViewerController::class, 'show'])->name('templates.show');
});

// Akses route untuk role 'Pengguna'
Route::middleware(['auth'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.submit');
});

// Akses route untuk role 'Supplier'
Route::middleware(['auth', 'verified'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/templates', [DesignTemplateController::class, 'index'])->name(name: 'templates.index');
    Route::get('/templates/create', [DesignTemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [DesignTemplateController::class, 'store'])->name('templates.store');
    Route::delete('/templates/{template}', [DesignTemplateController::class, 'destroy'])->name('templates.destroy');
});

require __DIR__ . '/auth.php';