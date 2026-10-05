<?php

use App\Http\Controllers\Admin\AccessLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EbookCommentController;
use App\Http\Controllers\Admin\EbookCommentReportController;
use App\Http\Controllers\Admin\EbookReportController;
use App\Http\Controllers\Admin\EbookController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Public\LibraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LibraryController::class, 'home'])->name('home');
Route::get('/perpustakaan', [LibraryController::class, 'library'])->name('library');
Route::get('/saran-pencarian', [LibraryController::class, 'searchSuggestions'])->name('search.suggestions');
Route::get('/sitemap.xml', [LibraryController::class, 'sitemap'])->name('sitemap');
Route::get('/kelas/{class}', [LibraryController::class, 'class'])->name('classes.show');
Route::get('/kelas/{class}/mata-pelajaran/{subject}', [LibraryController::class, 'subject'])->name('subjects.show');
Route::get('/ebook/{ebook}', [LibraryController::class, 'ebook'])->name('ebooks.show');
Route::get('/ebook/{ebook}/baca', [LibraryController::class, 'reader'])->name('ebooks.reader');
Route::get('/ebook/{ebook}/download', [LibraryController::class, 'download'])->name('ebooks.download');
Route::post('/ebook/{ebook}/laporan', [LibraryController::class, 'storeReport'])->middleware('throttle:5,1')->name('ebooks.reports.store');
Route::post('/ebook/{ebook}/komentar', [LibraryController::class, 'storeComment'])->middleware('throttle:comment-submissions')->name('ebooks.comments.store');
Route::post('/komentar/{comment}/laporkan', [LibraryController::class, 'storeCommentReport'])->middleware('throttle:comment-reports')->name('comments.reports.store');
Route::view('/favorit', 'public.favorites')->name('favorites');
Route::get('/komentar-siswa', [LibraryController::class, 'comments'])->name('comments.index');

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
        Route::get('/laporan-e-book', [EbookReportController::class, 'index'])->name('ebook-reports.index');
        Route::patch('/laporan-e-book/{report}', [EbookReportController::class, 'update'])->name('ebook-reports.update');
        Route::get('/komentar-e-book', [EbookCommentController::class, 'index'])->name('ebook-comments.index');
        Route::patch('/komentar-e-book/{comment}', [EbookCommentController::class, 'update'])->name('ebook-comments.update');
        Route::delete('/komentar-e-book/{comment}', [EbookCommentController::class, 'destroy'])->name('ebook-comments.destroy');
        Route::get('/laporan-komentar', [EbookCommentReportController::class, 'index'])->name('comment-reports.index');
        Route::patch('/laporan-komentar/{report}', [EbookCommentReportController::class, 'update'])->name('comment-reports.update');
    });
});
