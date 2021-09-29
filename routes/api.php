<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;



Route::get('/tags', [TagController::class, 'view'])->name('tags');

Route::get('/offices', [OfficeController::class, 'index'])->name('office.all');
