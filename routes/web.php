<?php

use Illuminate\Support\Facades\Route;

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

Route::get('skills', function () {
    return ['php','laravel','vue'];
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('courses', 'CoursesController@index');
Route::get('courses/create', 'CoursesController@create');
Route::post('courses', 'CoursesController@store');
//Route::get('/courses/{course}', 'CoursesController@show');
Route::get('/courses/{course}/edit', 'CoursesController@edit');
Route::put('/courses/{course}', 'CoursesController@update');
Route::post('/courses/fileupload', 'CoursesController@fileupload');

