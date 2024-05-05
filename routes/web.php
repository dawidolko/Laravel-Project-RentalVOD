<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPanel\EditUsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AdminPanel\EditMoviesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProblemsController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\ShareDataToViews;
use App\Http\Middleware\IsAdmin;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/regulamin', [HomeController::class, 'regulamin'])->name('regulamin');
Route::get('/search', [MoviesController::class, 'search'])->name('movies.search');

Route::get('/movies', [MoviesController::class, 'index'])->name('movies.index');
Route::get('/movie/{id}', [MoviesController::class, 'show'])->name('movies.show');

Route::middleware([ShareDataToViews::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/auth/login', 'login')->name('login');
        Route::post('/auth/login', 'authenticate')->name('login.authenticate');
        Route::get('/auth/logout', 'logout')->name('logout');
        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [UsersController::class, 'showProfile'])->name('user.profile');
        Route::post('/cart/update/{movie_id}', [UsersController::class, 'updateCart'])->name('cart.update');
        Route::post('/checkout', [UsersController::class, 'checkout'])->name('checkout');
        Route::get('/settings', [UsersController::class, 'showSettings'])->name('settings');
        Route::put('/user/update', [UsersController::class, 'update'])->name('user.update');
        Route::put('/user/change-password', [UsersController::class, 'changePassword'])->name('user.change_password');
        Route::put('/user/update-avatar', [UsersController::class, 'updateAvatar'])->name('user.update_avatar');
        Route::get('/cart', [UsersController::class, 'showCart'])->name('cart.show');
        Route::post('/cart/add/{movie_id}', [UsersController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/remove/{movie_id}', [UsersController::class, 'removeFromCart'])->name('cart.remove');
        Route::get('/movies/image/{id}', [MoviesController::class, 'image'])->name('movies.image');
        Route::post('/opinions', [OpinionController::class, 'store'])->name('opinions.store');
        Route::get('/loans/{movie}', [UsersController::class, 'showMovie'])->name('loans.show');
    });
    
    // routes/web.php
    Route::middleware(['auth', IsAdmin::class])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/movies', [AdminController::class, 'movies'])->name('admin.movies');
        Route::get('/admin/movies/edit/{id}', [AdminController::class, 'editMovie'])->name('admin.editMovie');
        Route::post('/admin/movies/update/{id}', [AdminController::class, 'updateMovie'])->name('admin.updateMovie');
        Route::post('/admin/movies/delete/{id}', [AdminController::class, 'deleteMovie'])->name('admin.deleteMovie');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
        Route::post('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
        Route::post('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
        Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    });
    // Route::middleware(['auth', 'is_admin'])->group(function () {
    //     Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    //     Route::get('/admin/movies', [AdminController::class, 'movies'])->name('admin.movies');
    //     Route::get('/admin/movies/edit/{id}', [AdminController::class, 'editMovie'])->name('admin.editMovie');
    //     Route::post('/admin/movies/update/{id}', [AdminController::class, 'updateMovie'])->name('admin.updateMovie');
    //     Route::post('/admin/movies/delete/{id}', [AdminController::class, 'deleteMovie'])->name('admin.deleteMovie');
    //     Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    //     Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
    //     Route::post('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    //     Route::post('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    //     Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    // });
    
});