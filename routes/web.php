<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeboardController as TimeboardControllerAlias;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WarehouseController;

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
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/warehouse', [WarehouseController::class, 'index'])->middleware(['auth', 'verified'])->name('warehouse');
Route::get('/warehouse/{id}', [WarehouseController::class, 'single'])->middleware(['auth', 'verified'])->name('warehouse_single');
Route::post('/warehouse/add-employee', [WarehouseController::class, 'addEmployee'])->middleware(['auth', 'verified'])->name('add_employee');
Route::post('/warehouse/remove-employee', [WarehouseController::class, 'remove'])->middleware(['auth', 'verified'])->name('remove_employee');

Route::get('/timeboard', [TimeboardControllerAlias::class, 'index'])->middleware(['auth', 'verified'])->name('timeboard');
Route::post('/timeboard/change', [TimeboardControllerAlias::class, 'change'])->middleware(['auth', 'verified'])->name('timeboard_change');

Route::get('/cars', [CarController::class, 'index'])->middleware(['auth', 'verified'])->name('cars');
Route::post('/cars/change', [CarController::class, 'change'])->middleware(['auth', 'verified'])->name('cars_change');

Route::get('/intranet', function () {
    return view('intranet')->with(['users' => App\Models\User::all()]);
})->middleware(['auth', 'verified'])->name('intranet');

require __DIR__ . '/auth.php';
