<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;

// Registration
Route::get('/signup',  [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);

// Login (Route) - 
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout (Route) -
Route::get('/logout', [AuthController::class, 'logout']);

// Dashboard (Route) - 
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');

// Users Table (Route) - 
Route::get('/users',              [UserController::class, 'userstable'])->name('users');
Route::post('/users',             [UserController::class, 'addUser']);
Route::get('/users/{id}/edit',    [UserController::class, 'editUser'])->name('users.edit');
Route::post('/users/{id}/update', [UserController::class, 'updateUser'])->name('users.update');
Route::get('/users/{id}/delete',  [UserController::class, 'deleteUser'])->name('users.delete');

// Reservation CRUD
Route::get('/reservations',              [ReservationController::class, 'index'])->name('reservations');
Route::post('/reservations',             [ReservationController::class, 'store']);
Route::get('/reservations/{id}/edit',    [ReservationController::class, 'edit'])->name('reservations.edit');
Route::post('/reservations/{id}/update', [ReservationController::class, 'update'])->name('reservations.update');
Route::get('/reservations/{id}/delete',  [ReservationController::class, 'destroy'])->name('reservations.delete');

// Profile Picture (Route) - 
Route::get('/profile',        [ProfileController::class, 'showProfile'])->name('profile');
Route::post('/updateProfile', [ProfileController::class, 'profile']);

// Root redirect
Route::get('/', fn() => redirect('/login'));
