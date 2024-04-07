<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SiteController;
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

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'verify'])->name('verify');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'createUser'])->name('user.create');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [SiteController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard', [SiteController::class, 'dashboard'])->name('dashboard');
    Route::resource('site-monitor', SiteController::class);

    Route::get('contacts/import', [ContactController::class, 'importView'])->name('contacts.import');
    Route::get('contacts/export', [ContactController::class, 'exportView'])->name('contacts.export');
    Route::get('contacts/fileExport', [ContactController::class, 'exportContacts']);
    Route::post('contacts/fileImport', [ContactController::class, 'importContacts']);
});
