<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware;

require __DIR__.'/auth.php';

Route::get('/', function () { return view('auth.login'); })->name('login')->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login')->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// user edit/delete/update routes - admin only
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');