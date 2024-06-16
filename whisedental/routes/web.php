<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {

    //registration route
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    //login route
    Route::get('login', 'login')->name('login');
    Route::post('login','loginAction')->name('login.action');

    //logout
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

//user Route
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
 
//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');

    //Admin Profile
    Route::get('/admin/profile', [AdminController::class,'profilepage'])->name('admin/profile');

    Route::get('/admin/inventory', [InventoryController::class,'index'])->name('admin/inventory');
    Route::get('/admin/inventory/create', [InventoryController::class,'create'])->name('admin/inventory/create');
    Route::post('/admin/inventory/store', [InventoryController::class,'store'])->name('admin/inventory/store');
    Route::get('/admin/inventory/edit/{id}', [InventoryController::class,'edit'])->name('admin/inventory/edit');
    Route::put('/admin/inventory/edit/{id}', [InventoryController::class,'update'])->name('admin/inventory/update');

    Route::get('/admin/maintenance', [MaintenanceController::class,'index'])->name('admin/maintenance');
});
