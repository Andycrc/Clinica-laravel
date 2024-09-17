<?php

use App\Http\Controllers\AdminDoctorController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

// PUNTO DE ENTRADA DE LA APLICACION
Route::get('/', function () {
    return redirect()->route('login');
});

// RUTA PARA EL DASHBOARD
Route::get('/dashboard', function () {

    // Cantidad doctores
    $cantidadPacientes = User::where('role_id')->whereNull('role_id')->count();

    // Cantidad consultas
    $cantidadConsultas = Appointment::count();

    return view('dashboard', compact('cantidadPacientes', 'cantidadConsultas'));
})->middleware(['auth', 'verified'])->name('dashboard');



// RUTA PARA ADMINISTAR EL PERFIL
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// RUTA PARA DOCTORES
Route::middleware(['auth', 'verified', 'checkRole:Admin'])->controller(AdminDoctorController::class)->group(function () {
    Route::get('doctor', 'index')->name('doctor');
    Route::get('doctor/create', 'create')->name('admin.doctor.create');
    Route::get('doctor/edit/{id}', 'edit')->name('admin.doctor.edit');
    Route::post('doctor/update/{id}', 'update')->name('admin.doctor.update');
    Route::get('doctor/report/{id}', 'report')->name('admin.doctor.report');
    Route::delete('doctor/delete/{id}', 'delete')->name('admin.doctor.delete');
    Route::post('doctor/store', 'store')->name('admin.doctor.store');
});

// RUTAS PARA CONSULTAS
Route::middleware(['auth', 'verified'])->controller(ConsultaController::class)->group(function () {
    Route::get('consulta', ConsultaController::class)->name('consulta');
    Route::get('consulta/create', 'create')->name('consulta.create');
    Route::get('consulta/detail', 'detail')->name('consulta.detail');
    Route::get('consulta/report/{id}', 'report')->name('consulta.report');


    // Rutas para editar y eliminar consultas con el parámetro {id}
    Route::get('consulta/edit/{id}', 'edit')->name('consulta.edit');
    Route::delete('consulta/delete/{id}', 'destroy')->name('consulta.destroy');
    Route::put('consulta/update/{id}', 'update')->name('consulta.update');
    Route::post('consulta/guardar-consulta', 'guardarConsulta')->name('consulta.guardarConsulta');
});

// RUTAS PARA PACIENTE
Route::middleware(['auth', 'verified'])->controller(PacienteController::class)->group(function () {
    Route::get('paciente', PacienteController::class)->name('paciente');

    Route::get('paciente/find', 'buscarUsuarioPorDui')->name('buscarUsuarioPorDui');

    Route::get('paciente/create', 'create')->name('paciente.create');
    Route::get('paciente/detail', 'detail')->name('paciente.detail');


    // Rutas para editar y eliminar consultas con el parámetro {id}
    Route::get('paciente/edit/{id}', 'edit')->name('paciente.edit');
    Route::delete('paciente/delete/{id}', 'delete')->name('paciente.delete');
    Route::put('paciente/update/{id}', 'update')->name('paciente.update');
    Route::post('paciente/store', 'store')->name('paciente.store');
});

// RUTAS DEL LOGIN
require __DIR__ . '/auth.php';
