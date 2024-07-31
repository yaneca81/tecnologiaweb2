<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectsController;
use App\Http\Controllers\ServicesController;
use App\Models\Services;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Register', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    //ruta para administrar mis proyectos
    Route::get('myproyects', [ProyectsController::class, 'index'])->name('myproyects.index');
    //ruta para crear proyectos
    Route::get('myproyects/create', [ProyectsController::class, 'create'])->name('myproyects.create');
    Route::post('myproyects', [ProyectsController::class, 'store'])->name('myproyects.store');

    //ruta para editar y actualizar proyectos
    Route::get('myproyects/{proyects}/edit', [ProyectsController::class, 'edit'])->name('myproyects.edit');
    Route::post('myproyects/{proyects}', [ProyectsController::class, 'update'])->name('myproyects.update');

    //ruta para eliminar un proyectos
    Route::delete('myproyects/{proyects}', [ProyectsController::class, 'destroy'])->name('myproyects.destroy');


    // ruta para poder mostrar todos los proyectos
    Route::get('allproyects', [ProyectsController::class, 'show'])->name('allproyects.show');


    //Likes Proyectos
    Route::post('/dashboard/proyects/{id}/like', [ProyectsController::class, 'like'])->name('proyects.like');
    // routes/web.php


    //Servicos de Freelances rutas

    //ruta para administrar mis servicos freelance
    Route::get('myservices', [ServicesController::class, 'index'])->name('myservices.index');

    //ruta para crear servicos
    Route::get('myservices/create', [ServicesController::class, 'create'])->name('myservices.create');
    Route::post('myservices', [ServicesController::class, 'store'])->name('myservices.store');

    //ruta para editar y actualizar servicios
    Route::get('myservices/{services}/edit', [ServicesController::class, 'edit'])->name('myservices.edit');
    Route::post('myservices/{services}', [ServicesController::class, 'update'])->name('myservices.update');

    //ruta para eliminar un servicios
    Route::delete('myservices/{services}', [ServicesController::class, 'destroy'])->name('myservices.destroy');

    // ruta para poder mostrar todos los servicios
    Route::get('allservices', [ServicesController::class, 'show'])->name('allservices.show');


    //ruta para dar like a servicios

    Route::post('/services/{id}/like', [ServicesController::class, 'like'])->name('services.like');

});

require __DIR__ . '/auth.php';
