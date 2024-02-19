<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', [UserController::class, 'UserDashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'UserStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/password/change/password', [UserController::class, 'ChangePasswordStore'])->name('password.change.store');

    Route::get('/user/book', [BookingController::class, 'UserBookList'])->name('user.book');
    Route::get('/book', [BookingController::class, 'Book'])->name('book');
    Route::post('/book/store', [BookingController::class, 'BookStore'])->name('book.store');
    Route::get('/book/cancel/{id}', [BookingController::class, 'CancelBooking'])->name('book.cancel');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','roles:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});


Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');


Route::middleware(['auth','roles:admin'])->group(function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/user', 'AllUser')->name('all.user');
        Route::get('/add/user', 'AddUser')->name('add.user');
        Route::post('/store/user', 'StoreUser')->name('store.user');
        Route::get('/edit/user/{id}', 'EditUser')->name('edit.user');
        Route::post('/update/user/{id}', 'UpdateUser')->name('update.user');
        Route::get('/update/bookPermission/{id}/{value}', 'UpdateUserBookPermission')->name('update.bookPermission');
        Route::get('/delete/user/{id}', 'DeleteUser')->name('delete.user');
    });

    Route::controller(RoomController::class)->group(function(){
        Route::get('/all/room', 'AllRoom')->name('all.room');
        Route::get('/add/room', 'AddRoom')->name('add.room');
        Route::post('/store/room', 'StoreRoom')->name('store.room');
        Route::get('/edit/room/{id}', 'EditRoom')->name('edit.room');
        Route::post('/update/room/{id}', 'UpdateRoom')->name('update.room');
        Route::get('/delete/room/{id}', 'DeleteRoom')->name('delete.room');
    });

    Route::controller(BookingController::class)->group(function(){
        Route::get('/all/booking', 'AllBooking')->name('all.booking');
        Route::get('/update/booking/{id}/{status}', 'UpdateBooking')->name('update.booking');
        Route::get('/delete/booking/{id}', 'DeleteBooking')->name('delete.booking');

        Route::get('/booking-calendar', 'BookingCalendar')->name('bookingCalendar');
        Route::get('/booking-id/{id}', 'BookingByID')->name('bookingByID');
    });
});






