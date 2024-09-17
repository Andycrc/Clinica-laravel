@extends('layouts/dashboardTemplate')

@section('title', 'Dashboard doctor')

@section('content')
    <h1 class="mt-4">Bienvenido, {{ Auth::user()->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">{{ Auth::user()->role->role_name }}</li>
    </ol>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Pacientes</div>
                    <div class="card-body text-center">
                        <h5 class="card-title display-5">
                            {{ $cantidadPacientes }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header">Consultas</div>
                    <div class="card-body text-center">
                        <h5 class="card-title display-5">
                            {{ $cantidadConsultas }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
