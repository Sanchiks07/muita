<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\InspectionsController;
use App\Http\Middleware;

require __DIR__.'/auth.php';

Route::get('/', function () { return view('auth.login'); })->name('login')->middleware('guest');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// user crud routes - admin only
Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');

// document crud routes - broker only
Route::get('/documents/create', [DocumentsController::class, 'create'])->name('documents.create')->middleware('auth');
Route::post('/documents', [DocumentsController::class, 'store'])->name('documents.store')->middleware('auth');
Route::get('/documents/{id}/edit', [DocumentsController::class, 'edit'])->name('documents.edit')->middleware('auth');
Route::put('/documents/{id}', [DocumentsController::class, 'update'])->name('documents.update')->middleware('auth');
Route::delete('/documents/{id}', [DocumentsController::class, 'destroy'])->name('documents.destroy')->middleware('auth');

// cases crud routes - inspector && analyst only
Route::get('/cases/create', [CasesController::class, 'create'])->name('cases.create')->middleware('auth');
Route::post('/cases', [CasesController::class, 'store'])->name('cases.store')->middleware('auth');
Route::get('/cases/{id}', [CasesController::class, 'show'])->name('cases.show')->middleware('auth');
Route::get('/cases/{id}/edit', [CasesController::class, 'edit'])->name('cases.edit')->middleware('auth');
Route::put('/cases/{id}', [CasesController::class, 'update'])->name('cases.update')->middleware('auth');
Route::delete('/cases/{id}', [CasesController::class, 'destroy'])->name('cases.destroy')->middleware('auth');

// risk scan routes - analyst only
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/risk-scan', [DashboardController::class, 'riskScan'])->name('risk.scan')->middleware('auth');

// inspections crud routes - inspector only
Route::get('/inspections', [InspectionsController::class, 'index'])->name('inspections')->middleware('auth');
Route::get('/inspection/create', [InspectionsController::class, 'create'])->name('inspections.create')->middleware('auth');
Route::post('/inspections', [InspectionsController::class, 'store'])->name('inspections.store')->middleware('auth');
Route::get('/inspections/{id}', [InspectionsController::class, 'show'])->name('inspections.show')->middleware('auth');
Route::get('/inspections/{id}/edit', [InspectionsController::class, 'edit'])->name('inspections.edit')->middleware('auth');
Route::put('/inspections/{id}', [InspectionsController::class, 'update'])->name('inspections.update')->middleware('auth');
Route::delete('/inspections/{id}', [InspectionsController::class, 'destroy'])->name('inspections.destroy')->middleware('auth');
// update route for inspection decision and explanation
Route::put('/inspections/{id}/decision', [InspectionsController::class, 'updateDecision'])->name('inspections.updateDecision');