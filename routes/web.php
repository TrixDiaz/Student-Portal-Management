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

    // Departments
    Route::view('/admin/departments', 'admin.departments.index')->name('admin.departments');
    Route::view('/admin/departments/create', 'admin.departments.create')->name('admin.departments.create');
    Route::view('/admin/departments/edit/{department_id}', 'admin.departments.edit')->name('admin.departments.edit');

    // Buildings
    Route::view('/admin/buildings', 'admin.buildings.index')->name('admin.buildings');
    Route::view('/admin/buildings/create', 'admin.buildings.create')->name('admin.buildings.create');
    Route::view('/admin/buildings/edit/{building_id}', 'admin.buildings.edit')->name('admin.buildings.edit');

    // Rooms
    Route::view('/admin/rooms', 'admin.rooms.index')->name('admin.rooms');
    Route::view('/admin/rooms/create', 'admin.rooms.create')->name('admin.rooms.create');
    Route::view('/admin/rooms/edit/{room_id}', 'admin.rooms.edit')->name('admin.rooms.edit');

    // Subjects
    Route::view('/admin/subjects', 'admin.subjects.index')->name('admin.subjects');
    Route::view('/admin/subjects/create', 'admin.subjects.create')->name('admin.subjects.create');
    Route::view('/admin/subjects/edit/{subject_id}', 'admin.subjects.edit')->name('admin.subjects.edit');

    // Sections
    Route::view('/admin/sections', 'admin.section.index')->name('admin.sections');
    Route::view('/admin/sections/create', 'admin.section.create')->name('admin.sections.create');
    Route::view('/admin/sections/edit/{section_id}', 'admin.section.edit')->name('admin.sections.edit');

    // Evaluations
    Route::view('/admin/evaluations', 'admin.evaluations.index')->name('admin.evaluations');
    Route::view('/admin/evaluations/create', 'admin.evaluations.create')->name('admin.evaluations.create');
    Route::view('/admin/evaluations/edit/{evaluation_id}', 'admin.evaluations.edit')->name('admin.evaluations.edit');

    // Teacher Room Section
    Route::view('/teacher/room/{subject_id}', 'teacher.room')->name('teacher.room');

    Route::view('/student/evaluation/{roomSection}', 'student.evaluation')->name('student.evaluation');
});
