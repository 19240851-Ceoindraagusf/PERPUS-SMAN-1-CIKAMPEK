<?php

use App\Http\Controllers\Admin\AccessLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EbookController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Public\LibraryController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/perpustakaan')->name('home');
Route::get('/perpustakaan', [LibraryController::class, 'library'])->name('library');
Route::get('/kelas/{class}', [LibraryController::class, 'class'])->name('classes.show');
Route::get('/kelas/{class}/mata-pelajaran/{subject}', [LibraryController::class, 'subject'])->name('subjects.show');
Route::get('/ebook/{ebook}', [LibraryController::class, 'ebook'])->name('ebooks.show');
Route::get('/ebook/{ebook}/download', [LibraryController::class, 'download'])->name('ebooks.download');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::redirect('/', '/admin/dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('classes', ClassController::class)->except('show');
        Route::resource('subjects', SubjectController::class)->except('show');
        Route::resource('ebooks', EbookController::class)->except('show');
        Route::get('/access-logs', [AccessLogController::class, 'index'])->name('access-logs.index');
    });
});
