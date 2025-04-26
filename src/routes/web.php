<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

Route::get('/', [ContactController::class, 'index']);
Route::match(['get', 'post'], '/confirm', [ContactController::class, 'confirm']);

/*Route::post('/confirm', [ContactController::class, 'confirm']);*/
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/auth/register', [ContactController::class, 'register']);
Route::get('/auth/login', [ContactController::class, 'login']);
/*Route::middleware('auth')->group(function () {
Route::get('/', [ContactController::class, 'index']);});後で有効にする*/
Route::get('/admin', [ContactController::class, 'admin']);
Route::get('/thanks', [ContactController::class, 'thanks']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');