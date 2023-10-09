<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('f', function () {
    return view('front.profile');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/add-rating', [App\Http\Controllers\CommentController::class, 'add_rating'])->name('add-rating');
    Route::post('/add/vote', [App\Http\Controllers\CommentController::class, 'add_vote'])->name('add-vote');
    Route::get('question/{id}/details', [App\Http\Controllers\QuestionController::class, 'details']);
    Route::get('search', [App\Http\Controllers\QuestionController::class, 'search'])->name('search');
    Route::post('question/add', [App\Http\Controllers\QuestionController::class, 'create'])->name('add-question');
    Route::post('add-comment', [App\Http\Controllers\CommentController::class, 'create'])->name('add-comment');
    // Profile Links
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('view-profile');
    Route::post('/Edit/Profile', [App\Http\Controllers\ProfileController::class, 'edit_profile'])->name('edit-profile');
    Route::get('question/{id}/delete', [App\Http\Controllers\ProfileController::class, 'delete_question']);
});
