<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingInvoiceController;
use App\Http\Controllers\PublicBookingController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinasi/{id}', [HomeController::class, 'showDestinasi'])->name('destinasi.show');

Route::get('/booking/{jadwal}', [PublicBookingController::class, 'create'])->name('booking.create');
Route::post('/booking/{jadwal}', [PublicBookingController::class, 'store'])->name('booking.store');

Route::get('/bookings/{booking}/invoice', [BookingInvoiceController::class, 'show'])->name('bookings.invoice.show');
Route::get('/bookings/{booking}/invoice/download', [BookingInvoiceController::class, 'download'])->name('bookings.invoice.download');
