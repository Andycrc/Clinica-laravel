@extends('layouts/dashboardTemplate')

@section('title', 'Detalle Pacientes')

@section('content')

<style>
    .img-profile {
        width: 100%;
        max-width: 120px;
        border-radius: 5px;
    }

    ul li {
        list-style: none;
    }
</style>

<!-- INICIO CONTENIDO -->
<div class="card mt-4">
    <div class="card-header fw-bold">
        Detalle paciente
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Imagen del paciente -->
            <div class="col-md-2 text-center">
               
            </div>
            <div class="col-md-8">
                <ul>
                    <li class="mt-2"> <b>Nombre:</b> <input type="text" class="form-control" readonly > </li>
                    <li class="mt-2"> <b>DUI:</b> <input type="text" class="form-control" readonly > </li>
                    <li class="mt-2"> <b>Carnet:</b> <input type="text" class="form-control" readonly > </li>
                    <li class="mt-2"> <b>Fecha de nacimiento:</b> <input type="text" class="form-control" readonly > </li>
                    <li class="mt-2"> <b>Dirección:</b> <input type="text" class="form-control" readonly > </li>
                </ul>
            </div>
            <div class="col-md-12 text-end">
                <a  title="Regresar" class="btn btn-dark">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
