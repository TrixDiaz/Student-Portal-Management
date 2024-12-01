<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Users
    Route::view('/admin/users', 'admin.users.index')->name('admin.users');
    Route::view('/admin/users/create', 'admin.users.create')->name('admin.users.create');
    Route::view('/admin/users/edit/{user_id}', 'admin.users.edit')->name('admin.users.edit');

    // Roles
    Route::view('/admin/roles', 'admin.roles.index')->name('admin.roles');
    Route::view('/admin/roles/create', 'admin.roles.create')->name('admin.roles.create');
    Route::view('/admin/roles/edit/{role_id}', 'admin.roles.edit')->name('admin.roles.edit');
});
