<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ChartJsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

// route accésible par les utilisateurs connécté
Route::group(['middleware' => ['auth']], function () {
// redirection home
Route::get("/home", [HomeController::class, "index"])->name('home');
Route::get("/api/products", [UserController::class, "product"])->name('product');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get("/user", [HomeController::class, "homes"])->name('user')->middleware('is_admin');
Route::get("/comptable", [HomeController::class, "compta"])->name('comptable.comptas')->middleware('is_admin');


});
// désactiver des routes reset password
Auth::routes([
    'verify' => false,
    'reset' => false
    
  ]);

// reset password
  Route::get("/reset/password", [ResetPasswordController::class, "reset_pass"])->name('auth.passwords.reset');


// example data json Api 
  Route::get("/api/listes", [UserController::class, "list"])->name('list');

// chart js exemple mini dashbord excercie Elyamaje 
Route::get('chartjs', [ChartJsController::class, 'chartjs'])->name('chartjs.index');

// chart js exemple mini dashbord excercie Elyamaje 
Route::get('data', [UserController::class, 'Pdfdata'])->name('pdfdata');
