<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordGeneratorController;

Route::get('/', [PasswordGeneratorController::class, 'index'])->name('home');
Route::GET('/generate-password', [PasswordGeneratorController::class, 'generate'])->name('generate-password');

