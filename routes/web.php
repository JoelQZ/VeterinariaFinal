<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use App\Models\Pet;
use App\Models\Owner;
use App\Models\Appointment;

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    $petsCount = Pet::count();
    $ownersCount = Owner::count();
    $appointmentsCount = Appointment::where('status', 'pendiente')->count();

    $todayAppointments = Appointment::with(['petRelation', 'ownerRelation'])
        ->orderBy('date', 'desc')
        ->orderBy('time', 'asc')
        ->get();

    return view('dashboard', compact('petsCount', 'ownersCount', 'appointmentsCount', 'todayAppointments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

    Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('/owners/create', [OwnerController::class, 'create'])->name('owners.create');
    Route::post('/owners', [OwnerController::class, 'store'])->name('owners.store');
    Route::get('/owners/{owner}/edit', [OwnerController::class, 'edit'])->name('owners.edit');
    Route::put('/owners/{owner}', [OwnerController::class, 'update'])->name('owners.update');
    Route::delete('/owners/{owner}', [OwnerController::class, 'destroy'])->name('owners.destroy');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::get('/api/owners/{owner}/pets', [AppointmentController::class, 'getPetsByOwner']);

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/sales/create/{appointment}', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
});

require __DIR__ . '/auth.php';