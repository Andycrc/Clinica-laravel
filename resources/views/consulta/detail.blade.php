@extends('layouts/dashboardTemplate')

@section('title', 'Detalle')

@section('content')
    {{-- $_SESSION['username'] --}}

    <!-- INICIO CONTENIDO -->
    <div class="card mt-4">
        <div class="card-header fw-bold">
            Detalle consulta
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="fw-bold">Paciente: </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Dui: </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Dui: </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Medicamento: </label>
                    <div class="table-responsive" style="height:60px;">
                        <table class="table table-bordered table-striped">

                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Fecha consulta: </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Padecimiento: </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Alergias: </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Doctor: </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label class="fw-bold">Descripción: </label>
                    <textarea class="form-control" readonly>
                    </textarea>
                </div>
                <div class="col-md-12 text-end">
                    <a href title="Reporte" class="btn btn-primary">
                        Generar reporte
                    </a>
                    <a title="Regresar" class="btn btn-dark">
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN CONTENIDO -->
@endsection
