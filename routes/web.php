<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('admin');

Route::get('/login', 'App\Http\Controllers\StagiaireController@index')->name('stagiaire.login');
Route::post('/register/stagiaire', 'StagiaireController@store')->name('stagiaire.register');
    Route::get('/stagiaire/create', 'StagiaireController@create')->name('create.stagiaire');
    Route::get('/stagiaire/index', 'StagiaireController@index')->name('index.stagiaire');

  


Route::get('/login', 'App\Http\Controllers\CoachController@index')->name('coach.login');
Route::get('/register', 'App\Http\Controllers\CoachController@index')->name('coach.register');
    Route::post('/create', [CoachController::class,'create'])->name('create');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    // Route::resource('stagiaire', StagiaireController::class);
    Route::resource('coach', CoachController::class);
    Route::resource('products', ProductController::class);
});  