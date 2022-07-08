<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'setting', 'as' => 'setting.'], static function () {
    Route::group(['prefix' => 'website', 'as' => 'website.'], static function () {
        Route::get('/', [Admin\WebsiteSettingController::class, 'index'])->name('index');
        Route::post('/', [Admin\WebsiteSettingController::class, 'store'])->name('store');
    });
});

Route::group(['prefix' => 'image', 'as' => 'image.'], static function () {
    Route::get('/fetch', [Admin\FileUploadController::class, 'fetchGallery'])->name('gallery.fetch');
    Route::post('/upload', [Admin\FileUploadController::class, 'storeGallery'])->name('gallery.upload');
    Route::delete('/delete', [Admin\FileUploadController::class, 'removeGallery'])->name('gallery.remove');
});
