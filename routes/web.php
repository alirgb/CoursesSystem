<?php

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

Auth::routes();
Route::resource('courses', 'CoursesController');

Route::get('/courses/enroll/{id}','CoursesController@enroll')->name('courses.enroll');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('users', 'UserController');

Route::post('/courses/storeFeedback','CoursesController@storeFeedback')->name('courses.storeFeedback');

Route::post('/courses/deleteFeedback','CoursesController@deleteFeedback')->name('courses.deleteFeedback');

