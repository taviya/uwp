<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\QuestionAnsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

// User
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('question-ans', QuestionAnsController::class)->middleware(['auth', 'role_check:user']);

// Admin
Route::prefix('admin')->group(function() {
    Route::get('login', [LoginController::class, 'showAdminLoginForm']);
    Route::post('login', [LoginController::class, 'adminLogin']);
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware(['auth', 'role_check:admin']);

Route::prefix('admin')->middleware(['auth', 'role_check:admin'])->group(function() {
    Route::resource('/category', CategoryController::class);
    Route::resource('/question', QuestionController::class);
    Route::get('/question-status-update/{id}', [QuestionController::class, 'statusChange'])->name('question.status');
});