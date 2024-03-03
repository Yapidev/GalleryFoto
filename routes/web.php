<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MyPhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadOrUpdateController;
use App\Models\Foto;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

// Group route yang hanya bisa diakses oleh user terautentifikasi
Route::middleware('auth')->group(function () {
    // Route Get
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('photo/{slug}', [FotoController::class, 'view'])->name('view-detail-photo');
    Route::get('my-photo', [MyPhotoController::class, 'index'])->name('my-photo');
    Route::get('create-photo', [UploadOrUpdateController::class, 'create'])->name('create-photo');
    Route::get('edit-photo/{photo}', [UploadOrUpdateController::class, 'edit'])->name('edit-photo');
    Route::get('my-album', [AlbumController::class, 'index'])->name('my-album');
    Route::get('album-details/{album}', [AlbumController::class, 'detail'])->name('album-detail');
    Route::get('private-album', [AlbumController::class, 'private'])->name('private-album');
    Route::get('download-photo/{photo}', [DownloadController::class, 'download'])->name('download-photo');

    // Route Post
    Route::post('upload-photo', [FotoController::class, 'upload'])->name('upload-photo');
    Route::post('post-comment/{foto_id}', [KomentarController::class, 'store'])->name('post-comment');
    Route::post('upload-album', [AlbumController::class, 'upload'])->name('upload-album');
    Route::post('like-photo/{photo}', [LikeController::class, 'like'])->name('like-photo');

    // Route Put
    Route::put('update-photo/{photo}', [FotoController::class, 'update'])->name('update-photo');

    // Route Delete
    Route::delete('delete-comment/{comment}', [KomentarController::class, 'deleteComment'])->name('delete-comment');
    Route::delete('delete-photo/{foto}', [FotoController::class, 'delete'])->name('delete-photo');
    Route::delete('delete-album/{album}', [AlbumController::class, 'delete'])->name('delete-album');

    // Profile Routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'profilePage')->name('profile.index');
        Route::patch('update-photo', 'updatePhotoProfileProcess')->name('profile.update-photo');
        Route::patch('update-password', 'updatePassword')->name('profile.update-password');
        Route::put('update-biodata', 'updateBiodata')->name('profile.update-biodata');
        Route::delete('delete-photo', 'deletePhoto')->name('profile.delete-photo');
    });
});
