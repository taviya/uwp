<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionAnsController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(function () {
//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('register', [AuthController::class, 'register']);
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::get('get_categories', [CategoryController::class, 'getCategory']);
Route::post('add_question', [QuestionAnsController::class, 'addQuestion'])->middleware('auth:sanctum');
Route::get('get_question_ans', [HomeController::class, 'getQuestionAns']);
Route::get('get_question_ans_auth', [HomeController::class, 'getQuestionAns'])->middleware('auth:sanctum');
Route::post('register', [AuthController::class, 'register']);