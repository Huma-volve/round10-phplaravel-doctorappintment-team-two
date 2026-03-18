<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\AdminAuth\AuthController;
use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\AdminDoctor\DoctorController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Admin\ReviewController;

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

Route::middleware(['admin:admin,doctor'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Pages (Accessible to Admin & Doctor)
    |--------------------------------------------------------------------------
    |
    | Note: Some sub-pages are restricted to Admin-only in the sidebar
    | and via nested middleware groups below.
    */

    Route::get('/', [HomeController::class, 'index'])->name('dashboard.index')->middleware(['auth', 'admin:admin,doctor']);

    /*
    |--------------------------------------------------------------------------
    | Chat Routes (Accessible to Admin & Doctor)
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
    | Admin-Only Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['admin:admin'])->group(function () {



    // users routes
    Route::prefix('admin')->group(function () {
        Route::get('/users',[UserController::class,'index'])->name('admin.users.index');
        // Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('admin.users.edit');
        // Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
        Route::delete('/users/{id}',[UserController::class,'destroy'])->name('admin.users.destroy');
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
            // doctor routes
            Route::get('/', [DoctorController::class, 'index'])->name('admin.doctors.index');
            Route::get('/create', [DoctorController::class, 'create'])->name('admin.doctors.create');
            Route::post('/', [DoctorController::class, 'store'])->name('admin.doctors.store');
            Route::get('/{id}/edit', [DoctorController::class, 'edit'])->name('admin.doctors.edit');
            Route::put('/{id}', [DoctorController::class, 'update'])->name('admin.doctors.update');
            Route::delete('/{id}', [DoctorController::class, 'destroy'])->name('admin.doctors.destroy');
            // specialization routes
            Route::get('/specialization', [DoctorController::class, 'indexSpecialization'])->name('admin.doctors.index-specialization');
            Route::get('/add-specialization', [DoctorController::class, 'createSpecialization'])->name('admin.doctors.create-specialization');
            Route::post('/add-specialization', [DoctorController::class, 'storeSpecialization'])->name('admin.doctors.store-specialization');
            Route::get('/{id}/edit-specialization', [DoctorController::class, 'editSpecialization'])->name('admin.doctors.edit-specialization');
            Route::put('/{id}/update-specialization', [DoctorController::class, 'updateSpecialization'])->name('admin.doctors.update-specialization');
            Route::delete('/{id}/delete-specialization', [DoctorController::class, 'destroySpecialization'])->name('admin.doctors.destroy-specialization');
            // clinic routes
            Route::get('/clinic', [DoctorController::class, 'indexClinic'])->name('admin.doctors.index-clinic');
            Route::get('/add-clinic', [DoctorController::class, 'createClinic'])->name('admin.doctors.create-clinic');
            Route::post('/add-clinic', [DoctorController::class, 'storeClinic'])->name('admin.doctors.store-clinic');
            Route::get('/{id}/edit-clinic', [DoctorController::class, 'editClinic'])->name('admin.doctors.edit-clinic');
            Route::put('/{id}/update-clinic', [DoctorController::class, 'updateClinic'])->name('admin.doctors.update-clinic');
            Route::delete('/{id}/delete-clinic', [DoctorController::class, 'destroyClinic'])->name('admin.doctors.destroy-clinic');
        });
   Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
        /*
        |--------------------------------------------------------------------------
        | Profile Management
        |--------------------------------------------------------------------------
        */
        Route::get('/profile', [\App\Http\Controllers\Dashboard\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Dashboard\ProfileController::class, 'update'])->name('profile.update');
        //BOOKING
        Route::prefix('admin/Booking')->group(function () {
         Route::get('/', [BookingController::class, 'index'])->name('admin.booking.index');
         Route::get('/create', [BookingController::class, 'create'])->name('admin.booking.create');
        //  Route::get('/', [BookingController::class, 'index'])->name('admin.booking.index');
         
        });
    });

});