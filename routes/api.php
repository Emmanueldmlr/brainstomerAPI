<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [UserController::class, 'loginOrRegister']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/withdraw', [UserController::class, 'withdraw']);
    Route::get('/get-questions', [ExamController::class, 'getQuestions']);
    Route::put('/start-exam', [ExamController::class, 'startExam']);
    Route::get('/resume-exam', [ExamController::class, 'resumeExam']);
    Route::post('/grade-exam', [ExamController::class, 'gradeExam']);
    Route::get('/review-exam', [ExamController::class, 'reviewExam']);
    Route::get('/get-results', [ExamController::class, 'results']);
});
