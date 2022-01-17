<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\UserController;

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

});
// désactiver des routes reset passeword
Auth::routes([
    'verify' => false,
    'reset' => false
  ]);

// example data json Api 
  Route::get("/api/listes", [UserController::class, "list"])->name('list');