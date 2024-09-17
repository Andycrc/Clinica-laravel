@extends('layouts/dashboardTemplate')

@section('title', 'Crear Paciente')

@section('content')


    @if (session('error'))
        <div class="alert alert-danger mt-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif


    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mt-3 mb-4">
        <div class="card-header fw-bold">
            Ingresar paciente
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form id="agregarForm" class="needs-validation" novalidate method="post" enctype="multipart/form-data"
                        action="{{ route('paciente.store') }}">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Datos personales</h2>
                                    <hr>
                            </div>

                            <!-- Nombres -->
                            <div class="col-md-6">
                                <!-- Primer nombre -->
                                <div class="form-group">
                                    <label for="primer_nombre">Primer nombre *</label>
                                    <input type="text" name="primer_nombre" id="primer_nombre" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                    <label class="invalid-feedback"> Has olvidado añadir el primer nombre o el campo
                                        contiene caracteres inválidos.</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Segundo nombre -->
                                <div class="form-group">
                                    <label for="segundo_nombre">Segundo nombre</label>
                                    <input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                    <label class="invalid-feedback"> Has olvidado añadir el segundo nombre o el campo
                                        contiene caracteres inválidos.</label>
                                </div>
                            </div>


                            <!-- Apellidos -->
                            <div class="col-md-6">
                                <!-- Primer apellido -->
                                <div class="form-group">
                                    <label for="primer_apellido">Primer apellido *</label>
                                    <input type="text" name="primer_apellido" id="primer_apellido" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                    <label class="invalid-feedback"> Has olvidado añadir el primer apellido o el campo
                                        contiene caracteres inválidos.</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Segundo apellido -->
                                <div class="form-group">
                                    <label for="segundo_apellido">Segundo apellido *</label>
                                    <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                    <label class="invalid-feedback"> Has olvidado añadir el segundo apellido o el campo
                                        contiene caracteres inválidos.</label>
                                </div>
                            </div>

                            <!-- DATOS GENERALES -->
                            <div class="col-md-6">
                                <!-- Numero de DUI -->
                                <div class="form-group">
                                    <label for="numero_dui">DUI *</label>
                                    <input type="text" name="numero_dui" id="numero_dui" class="form-control"
                                        pattern="[0-9]{8}-[0-9]" required>
                                    <label class="invalid-feedback">Ingresa un número de DUI válido (10 dígitos)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Departamento -->
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <select name="departamento" id="departamento" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Municipio -->
                                <div class="form-group">
                                    <label for="municipio">Municipio</label>
                                    <select name="municipio" id="municipio" class="form-control">
                                        <option value="">Seleccionar ...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Fecha de nacimiento  -->
                                <div class="form-group">
                                    <label for="fecha_nacimiento">Fecha de nacimiento *</label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" max=''
                                        class="form-control" required>
                                    <label class="invalid-feedback"> Has olvidado seleccionar una fecha</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <!-- Fecha de nacimiento  -->
                                <div class="form-group">
                                    <label for="foto_paciente">Fotográfia </label>
                                    <input type="file" name="foto_paciente" id="foto_paciente" class="form-control"
                                        accept="image/jpeg, image/png">
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <input type="submit" title="Guardar paciente" class="btn btn-primary" value="Guardar"
                                    name="AgregarPaciente">
                                <a title="Regresar" class="btn btn-dark" href="{{ route('paciente') }}">
                                    Regresar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        const $departamento = document.getElementById('departamento');
        const $municipio = document.getElementById('municipio');
        document.addEventListener('DOMContentLoaded', () => {
            showLoadingModal('departamentos');
            // Cargar los departamentos
            ajaxCountries({
                url: 'https://api.countrystatecity.in/v1/countries/SV/states',
                cbSuccess: async (json) => {
                    await loadDepartamentos({
                        departamentos: json,
                        departamentoAlmacenado: null
                    });
                    hideLoadingModal();
                }
            });


        });

        $departamento.addEventListener('change', () => {

            const selectedOption = $departamento.options[$departamento.selectedIndex];
            const codigoDepartamento = selectedOption.getAttribute('data-iso2');

            showLoadingModal('municipios');

            ajaxCountries({
                url: `https://api.countrystatecity.in/v1/countries/SV/states/${codigoDepartamento}/cities`,
                cbSuccess: async (json) => {
                    await loadMunicipios({
                        municipios: json,
                        municipioAlmacenado: null
                    })
                    hideLoadingModal();
                }
            });

        })


        //Validar fecha de nacimiento
        const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
        const fechaNacimientoError = fechaNacimientoInput.nextElementSibling;

        fechaNacimientoInput.addEventListener('input', () => {
            const inputDate = new Date(fechaNacimientoInput.value);
            const today = new Date();

            if (isNaN(inputDate.getTime()) || inputDate > today) {
                fechaNacimientoInput.setCustomValidity('Ingresa una fecha de nacimiento válida');
                fechaNacimientoError.textContent = 'Ingresa una fecha de nacimiento válida';
            } else {
                fechaNacimientoInput.setCustomValidity('');
                fechaNacimientoError.textContent = '';
            }
        });
    </script>
@endsection
