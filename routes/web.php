<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentsController;
use App\Http\Middleware;

require __DIR__.'/auth.php';

Route::get('/', function () { return view('auth.login'); })->name('login')->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login')->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// user crud routes - admin only
Route::get('/users/create', [UserController::class, 'create'])->name('user_create')->middleware('auth');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');

// document crud routes - broker only
Route::get('/documents/create', [DocumentsController::class, 'create'])->name('document_create')->middleware('auth');
Route::post('/documents', [DocumentsController::class, 'store'])->name('documents.store')->middleware('auth');

// cases crud routes - inspector && analyst only
Route::get('/cases/create', [CasesController::class, 'create'])->name('case_create')->middleware('auth');
Route::post('/cases', [CasesController::class, 'store'])->name('cases.store')->middleware('auth');
Route::get('/cases/{id}/edit', [CasesController::class, 'edit'])->name('cases.edit')->middleware('auth');
Route::put('/cases/{id}', [CasesController::class, 'update'])->name('cases.update')->middleware('auth');
Route::delete('/cases/{id}', [CasesController::class, 'destroy'])->name('cases.destroy')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');