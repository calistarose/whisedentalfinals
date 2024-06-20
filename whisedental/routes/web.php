<?php

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Patients;


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
    return view('\welcome');
});

// Route::controller(AuthController::class)->group(function () {

//     //registration route
//     Route::get('register', 'register')->name('register');
//     Route::post('register', 'registerSave')->name('register.save');

//     //login route
//     Route::get('login', 'login')->name('login');
//     Route::post('login','loginAction')->name('login.action');

//     //OTP Route
//     Route::get('enter_otp', 'enter_otp')->name('enter_otp');
//     Route::post('verify2FA','verify2FA')->name('verify_2fa');
//     // Route::post('/verify-2fa', [AuthController::class, 'verify2FA'])->name('verify_2fa');

//     //logout
//     Route::get('logout', 'logout')->middleware('auth')->name('logout');
// });

Route::controller(AuthController::class)->group(function () {

    // Registration routes
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerSave'])->name('register.save');

    // Login routes
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');

    

    // OTP Route
    //Route::get('enter_otp', [AuthController::class, 'enter_otp'])->name('enter_otp');
    // Route::post('verify_2fa', [AuthController::class, 'verify2FA'])->name('verify_2fa');

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// Route::get('/verify2FA', [google2FAController::class, 'verify2FA'])->name('verify2FA');
// Route::get('/enter_otp', [google2FAController::class, 'enter_otp'])->name('enter_otp');
// Route::post('/verify2FA', [google2FAController::class, 'verify2FA'])->name('verify2FA'); // Add this line for POST requests




//user Route
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/enter-otp', [AuthController::class, 'enterOTP'])->name('enter_otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify.otp');
});
 
//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');
    Route::get('/enter-otp', [AuthController::class, 'enterOTP'])->name('enter_otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify.otp');

    //Admin Profile
    Route::get('/admin/profile', [AdminController::class,'profilepage'])->name('admin/profile');

    //Inventory Route List
    Route::get('/admin/inventory', [InventoryController::class,'index'])->name('admin/inventory');
    Route::get('/admin/inventory/create', [InventoryController::class,'create'])->name('admin/inventory/create');
    Route::post('/admin/inventory/store', [InventoryController::class,'store'])->name('admin/inventory/store');
    Route::get('/admin/inventory/edit/{id}', [InventoryController::class,'edit'])->name('admin/inventory/edit');
    Route::put('/admin/inventory/edit/{id}', [InventoryController::class,'update'])->name('admin/inventory/update');

    //Maintenance Route List
    Route::get('/admin/maintenance', [MaintenanceController::class,'index'])->name('admin/maintenance');
});

//Appointment
Route::middleware(['auth'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/appointments/available-times', [AppointmentController::class, 'availableTimes'])->name('appointments.availableTimes');
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::get('/todays-appointments', [AppointmentController::class, 'todaysAppointmentsCount']);
});

Route::get('/payments', [PaymentController::class, 'index'])->name('payments/home');
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');


Route::get('/patient', [Patients::class,'index'])->name('patient');
Route::get('/patient/show/{id}', [Patients::class,'show'])->name('patient/show');
Route::get('/patient/add', [Patients::class, 'addPatient'])->name('patient/add');
Route::post('/patient/store', [Patients::class,'store'])->name('patient/store');
Route::get('/patient/edit/{id}', [Patients::class,'edit'])->name('patient/edit');
Route::put('/patient/edit/{id}', [Patients::class,'update'])->name('patient/update');


Route::get('/income', [ReportsController::class,'index'])->name('income/home');
Route::get('/income/get', [ReportsController::class,'getIncome'])->name('get/income');
Route::post('/income/get', [ReportsController::class,'getIncome'])->name('get/income/');
// Route::get('/download-report/{type}', [ReportsController::class, 'downloadReport'])->name('download/report');
// Route::get('/income/show', [ReportsController::class, 'showIncomeView'])->name('show/income/view');

Route::get('/search', [Patients::class, 'search'])->name('search');



