<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingInvoiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bookings/{booking}/invoice', [BookingInvoiceController::class, 'show'])->name('bookings.invoice.show');
Route::get('/bookings/{booking}/invoice/download', [BookingInvoiceController::class, 'download'])->name('bookings.invoice.download');
