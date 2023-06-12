<?php

use App\Filament\Resources\QuizResource\Pages\AnswerQuiz;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\User\QuizController;
use App\Http\Controllers\User\TopicController;
use App\Http\Controllers\DummyController;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('pvs/login');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/feedback', function() { return view('feedback'); });
Route::post('/feedback_data', [FeedbackController::class, 'feedback_data'])->name('feedback_data');

Route::get('/maybank', function() { return view('maybank'); });
Route::get('/ump', function() { return view('ump'); });