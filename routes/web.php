<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\AdminController;
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

// PUBLIC ROUTES
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/ppdb', [PublicController::class, 'ppdb'])->name('ppdb');
Route::post('/ppdb', [PPDBController::class, 'store'])->name('ppdb.store');
Route::get('/kegiatan', [PublicController::class, 'kegiatan'])->name('kegiatan');
Route::get('/program', [PublicController::class, 'program'])->name('program');
Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [PublicController::class, 'sendContact'])->name('kontak.send');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');

// ADMIN ROUTES
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // PPDB Management
    Route::get('/ppdb', [AdminController::class, 'ppdbIndex'])->name('ppdb.index');
    Route::get('/ppdb/{id}', [AdminController::class, 'ppdbShow'])->name('ppdb.show');
    Route::patch('/ppdb/{id}/status/{status}', [AdminController::class, 'ppdbUpdateStatus'])->name('ppdb.updateStatus');
    Route::get('/ppdb/export/excel', [AdminController::class, 'ppdbExport'])->name('ppdb.export');

    // Program Management
    Route::resource('program', \App\Http\Controllers\AdminController::class, ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']])->names([
        'index' => 'admin.program.index',
        'create' => 'admin.program.create',
        'store' => 'admin.program.store',
        'edit' => 'admin.program.edit',
        'update' => 'admin.program.update',
        'destroy' => 'admin.program.destroy',
    ]);

    Route::get('/program', [AdminController::class, 'programIndex'])->name('program.index');
    Route::get('/program/create', [AdminController::class, 'programCreate'])->name('program.create');
    Route::post('/program', [AdminController::class, 'programStore'])->name('program.store');
    Route::get('/program/{id}/edit', [AdminController::class, 'programEdit'])->name('program.edit');
    Route::put('/program/{id}', [AdminController::class, 'programUpdate'])->name('program.update');
    Route::delete('/program/{id}', [AdminController::class, 'programDestroy'])->name('program.destroy');

    // Activity Management
    Route::get('/activity', [AdminController::class, 'activityIndex'])->name('activity.index');
    Route::get('/activity/create', [AdminController::class, 'activityCreate'])->name('activity.create');
    Route::post('/activity', [AdminController::class, 'activityStore'])->name('activity.store');
    Route::get('/activity/{id}/edit', [AdminController::class, 'activityEdit'])->name('activity.edit');
    Route::put('/activity/{id}', [AdminController::class, 'activityUpdate'])->name('activity.update');
    Route::delete('/activity/{id}', [AdminController::class, 'activityDestroy'])->name('activity.destroy');

    // Gallery Management
    Route::get('/gallery', [AdminController::class, 'galleryIndex'])->name('gallery.index');
    Route::get('/gallery/create', [AdminController::class, 'galleryCreate'])->name('gallery.create');
    Route::post('/gallery', [AdminController::class, 'galleryStore'])->name('gallery.store');
    Route::delete('/gallery/{id}', [AdminController::class, 'galleryDestroy'])->name('gallery.destroy');

    // Announcement Management
    Route::get('/announcement', [AdminController::class, 'announcementIndex'])->name('announcement.index');
    Route::get('/announcement/create', [AdminController::class, 'announcementCreate'])->name('announcement.create');
    Route::post('/announcement', [AdminController::class, 'announcementStore'])->name('announcement.store');
    Route::get('/announcement/{id}/edit', [AdminController::class, 'announcementEdit'])->name('announcement.edit');
    Route::put('/announcement/{id}', [AdminController::class, 'announcementUpdate'])->name('announcement.update');
    Route::delete('/announcement/{id}', [AdminController::class, 'announcementDestroy'])->name('announcement.destroy');

    // FAQ Management
    Route::get('/faq', [AdminController::class, 'faqIndex'])->name('faq.index');
    Route::get('/faq/create', [AdminController::class, 'faqCreate'])->name('faq.create');
    Route::post('/faq', [AdminController::class, 'faqStore'])->name('faq.store');
    Route::get('/faq/{id}/edit', [AdminController::class, 'faqEdit'])->name('faq.edit');
    Route::put('/faq/{id}', [AdminController::class, 'faqUpdate'])->name('faq.update');
    Route::delete('/faq/{id}', [AdminController::class, 'faqDestroy'])->name('faq.destroy');

    // School Info Management
    Route::get('/school-info/edit', [AdminController::class, 'schoolInfoEdit'])->name('school-info.edit');
    Route::put('/school-info', [AdminController::class, 'schoolInfoUpdate'])->name('school-info.update');
});
