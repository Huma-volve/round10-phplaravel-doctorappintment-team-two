<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard.index');

Route::get('/students', function () {
    return view('dashboard.students');
})->name('students');

Route::get('/teachers', function () {
    return view('dashboard.teacher');
})->name('teachers');

Route::get('/add-course', function () {
    return view('dashboard.add-course');
})->name('add-course');

Route::get('/courses', function () {
    return view('dashboard.course');
})->name('courses');

Route::get('/course-details', function () {
    return view('dashboard.course-details');
})->name('course-details');

Route::get('/add-category', function () {
    return view('dashboard.addCategory');
})->name('add-category');

Route::get('/data-table', function () {
    return view('dashboard.data-table');
})->name('data-table');

Route::get('/bootstrap-table', function () {
    return view('dashboard.table-bootstrap');
})->name('bootstrap-table');

Route::get('/library', function () {
    return view('dashboard.library');
})->name('library');

Route::get('/department', function () {
    return view('dashboard.department');
})->name('department');

Route::get('/staff', function () {
    return view('dashboard.staff');
})->name('staff');

Route::get('/fees', function () {
    return view('dashboard.fees');
})->name('fees');

Route::get('/form', function () {
    return view('dashboard.form');
})->name('form');

Route::get('/login-dash', function () {
    return view('dashboard.login');
})->name('login-dash');

Route::get('/signup-dash', function () {
    return view('dashboard.signup');
})->name('signup-dash');

Route::get('/forgot-password-dash', function () {
    return view('dashboard.forgot-password');
})->name('forgot-password-dash');

Route::get('/404-dash', function () {
    return view('dashboard.404');
})->name('404-dash');

Route::get('/500-dash', function () {
    return view('dashboard.500');
})->name('500-dash');
