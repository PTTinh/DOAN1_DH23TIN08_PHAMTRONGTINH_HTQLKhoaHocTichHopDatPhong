<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoomBookingDetailController;
use App\Http\Controllers\SitemapController;


// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::post('/room-booking-details/{id}/reject', [RoomBookingDetailController::class, 'reject'])->name('admin.room-booking-details.reject');
    Route::post('/room-booking-details/{id}/cancel', [RoomBookingDetailController::class, 'cancel'])->name('admin.room-booking-details.cancel');
    Route::post('/chi-tiet-dat-phong/{id}/reject', [RoomBookingDetailController::class, 'reject'])->name('admin.chi-tiet-dat-phong.reject');
    Route::post('/chi-tiet-dat-phong/{id}/cancel', [RoomBookingDetailController::class, 'cancel'])->name('admin.chi-tiet-dat-phong.cancel');
});

// Sitemap route
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
