<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\AdminAuth\AuthController;
use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\AdminDoctor\DoctorController;

/*
|--------------------------------------------------------------------------
| Auth Routes (بدون Middleware)
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('show-login');
    Route::post('/login', [AuthController::class, 'login'])->name('login-dash');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout-dash');

});

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


/*
|--------------------------------------------------------------------------
| Admin Middleware Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Pages
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard.index')->middleware(['auth','admin']);

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


    /*
    |--------------------------------------------------------------------------
    | Chat Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard/chat')->group(function () {

        Route::get('/', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/{chat}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/{chat}/message', [ChatController::class, 'store'])->name('chat.message.store');
        Route::delete('/message/{message}', [ChatController::class, 'destroyMessage'])->name('chat.message.destroy');
        Route::post('/chats/{chat}/favorite', [ChatController::class, 'toggleFavorite'])->name('chat.favorite.toggle');

    });


    /*
    |--------------------------------------------------------------------------
    | FAQ & Policies
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->group(function () {

        Route::get('/', [FaqController::class, 'index'])->name('faqs.index');

        Route::get('/faqs', [FaqController::class, 'create'])->name('faqs.create');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('faqs.destroy');

        Route::get('/policies', [PolicyController::class, 'index'])->name('policies.index');
        Route::get('/policies/create', [PolicyController::class, 'create'])->name('policies.create');
        Route::post('/policies', [PolicyController::class, 'store'])->name('policies.store');
        Route::delete('/policies/{id}', [PolicyController::class, 'destroy'])->name('policies.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | Admin Doctors
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/doctor')->group(function () {

        Route::get('/', [DoctorController::class, 'index'])->name('admin.doctors.index');
        Route::get('/create', [DoctorController::class, 'create'])->name('admin.doctors.create');
        Route::post('/', [DoctorController::class, 'store'])->name('admin.doctors.store');
        Route::delete('/{id}', [DoctorController::class, 'destroy'])->name('admin.doctors.destroy');

    });

});