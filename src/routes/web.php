<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Models\Category;

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
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::match(['get', 'post'], '/confirm', [ContactController::class, 'confirm']);
Route::middleware('auth')->group(function () {
Route::get('/admin', [ContactController::class, 'admin']);
Route::get('/admin/search', [ContactController::class, 'search'])->name('admin.search');
Route::get('/admin/export', [ContactController::class, 'export'])->name('contacts.export');
Route::get('/thanks', [ContactController::class, 'thanks']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');