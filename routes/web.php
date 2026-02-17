<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/permission', PermissionController::class);
    Route::resource('/role', RoleController::class);
    Route::get('/role/{id}/add-permissions', [RoleController::class , 'addPermissionToRole'])->name('addPermissionToRole');
    Route::put('/role/{id}/give-permissions', [RoleController::class , 'givePermissionToRole'])->name('givePermissionToRole');
    Route::resource('/user', UserController::class);
    Route::get('welcome-page', function () {
            return view('role-permission.welcome-page');
        }
        )->name('welcome-page');
    });
