@extends('layouts/dashboardTemplate')

@section('title', 'Crear')

@section('content')
    <style>
        .table-fixed-header thead {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
        }
    </style>

    <div class="card mt-3 mb-4">
        <div class="card-header fw-bold">
            Crear consulta médica
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="card mt-3 mb-4">
                        <div class="card-header fw-bold">
                            Buscar paciente
                        </div>
                        <div class="card-body">
                            <form id="buscarForm" method="get">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="numero_dui">DUI</label>
                                            <input type="text" name="numero_dui" id="numero_dui" class="form-control"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" readonly>
                                        <label>DUI</label>
                                        <input type="text" name="dui_resultado" id="dui_resultado" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" id="btn_buscar">Buscar</button>
                                                <a href="{{route('paciente.create')}}" class="btn btn-primary">Agregar paciente</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                    <hr>

                    <form action="{{route('consulta.guardarConsulta')}}" class="needs-validation" novalidate method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <!-- Hidden field for dui_resultado -->
                            <input type="hidden" name="id_resultado" id="id_resultado_hidden" value="">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descripcion">Descripción *</label>
                                    <textarea type="text" name="descripcion" id="descripcion" class="form-control" required></textarea>
                                    <label class="invalid-feedback"> Has olvidado añadir la descripción</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="diagnostico">Diagnostico  *</label>
                                    <textarea type="text" name="diagnostico" id="diagnostico" class="form-control" required></textarea>
                                    <label class="invalid-feedback"> Has olvidado añadir el diagnostico</label>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="next_appointment" class="form-label">Próxima cita</label>
                                    <input type="date" class="form-control" id="next_appointment" name="next_appointment">
                                </div>
                            </div>

                            <div class="col-md-12 text-end">
                                <input type="submit" title="Guardar paciente" class="btn btn-primary" value="Guardar"
                                    name="AgregarConsulta">
                                <a href="{{route('consulta')}}" title="Regresar" class="btn btn-dark">Regresar</a>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <script>
        // Manejo del evento submit del formulario
        $('#buscarForm').submit(function(e) {
            e.preventDefault(); // Detenemos el comportamiento predeterminado del formulario

            var dui = $('#numero_dui').val();

            $.ajax({
                url: '/paciente/find',
                method: 'GET',
                data: {
                    numero_dui: dui
                },
                success: function(data) {
                    // Aquí manejas la respuesta JSON y llenas los campos del formulario
                    if (data && data.user && data.user.name && data.user.dui && data.user.user_id) {
                        $('#nombre').val(data.user.name);
                        $('#dui_resultado').val(data.user.dui);

                        // Set the value of the hidden field in the "Guardar paciente" form
                        $('#id_resultado_hidden').val(data.user.user_id);
                    } else {
                        showWarningAlert('No se encontró el paciente con el DUI proporcionado');
                    }
                },
                error: function(error) {
                    showWarningAlert('No se encontró el paciente con el DUI proporcionado');
                }
            });
        });

        function showWarningAlert(mensaje) {
            Swal.fire({
                icon: 'warning',
                title: '¡Advertencia!',
                text: mensaje,
                confirmButtonText: 'Aceptar'
            });
        }
    </script>
@endsection
