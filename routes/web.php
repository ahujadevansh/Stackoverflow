<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('users/notifications', 'UsersController@notifications')->name('users.notifications');

Route::resource('questions', 'QuestionsController')->except('show');
Route::get('questions/{slug}', 'QuestionsController@show')->name('questions.show');
Route::resource('questions.answers', 'AnswersController')->except('index', 'show', 'index');
Route::put('/answers/{answer}/best-answer', 'AnswersController@bestAnswer')->name('answers.bestAnswer');
Route::get('/home', 'HomeController@index')->name('home');

Route::post('questions/{question}/favourite', 'FavouritesController@store')->name('questions.favourite');
Route::delete('questions/{question}/unfavourite', 'FavouritesController@destroy')->name('questions.unfavourite');

Route::post('questions/{question}/upvote', 'VotesController@upVoteQuestion')->name('questions.upvote');
Route::post('questions/{question}/downvote', 'VotesController@downVoteQuestion')->name('questions.downvote');

Route::post('answers/{answer}/upvote', 'VotesController@upVoteAnswer')->name('answers.upvote');
Route::post('answers/{answer}/downvote', 'VotesController@downVoteAnswer')->name('answers.downvote');
