@extends('layouts/dashboardTemplate')

@section('title', 'Crear doctores')

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
    <!-- INICIO CONTENIDO -->
    <div class="card mt-3 mb-4">
        <div class="card-header fw-bold">
            Crear Doctor
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.doctor.store') }}" class="needs-validation" novalidate method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Datos personales</h2>
                                    <hr>
                            </div>

                            <!--Envia a controlador-->
                            <div class="col-md-6">
                                <!-- Primer nombre -->
                                <div class="form-group">
                                    <label for="primer_nombre">Primer nombre *</label>
                                    <input type="text" name="primer_nombre" id="primer_nombre" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                        title="Olvidaste añadir el primer nombre o el campo contiene caracteres inválidos.">
                                    <label class="invalid-feedback">Por favor, revisar el campo </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Segundo nombre -->
                                <div class="form-group">
                                    <label for="segundo_nombre">Segundo nombre *</label>
                                    <input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                        title="Olvidaste añadir el segundo nombre o el campo contiene caracteres inválidos.">
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>
                            <!-- Apellidos -->
                            <div class="col-md-6">
                                <!-- Primer apellido -->
                                <div class="form-group">
                                    <label for="primer_apellido">Primer apellido *</label>
                                    <input type="text" name="primer_apellido" id="primer_apellido" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                        title="Olvidaste añadir el primer apellido o el campo contiene caracteres inválidos.">
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Segundo apellido -->
                                <div class="form-group">
                                    <label for="segundo_apellido">Segundo apellido *</label>
                                    <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control"
                                        required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                        title="Olvidaste añadir el segundo apellido o el campo contiene caracteres inválidos.">
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Segundo apellido -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control">
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>

                            <!-- DATOS GENERALES -->
                            <div class="col-md-6">
                                <!-- Numero de DUI -->
                                <div class="form-group">
                                    <label for="numero_dui">DUI *</label>
                                    <input type="text" name="numero_dui" id="numero_dui" class="form-control"
                                        pattern="[0-9]{8}-[0-9]" required placeholder="xxxxxxxx-x"
                                        title="Ingresa un número de DUI válido (10 dígitos)">
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Departamento -->
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <select name="departamento" id="departamento" class="form-control" required>

                                    </select>
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Municipio -->
                                <div class="form-group">
                                    <label for="municipio">Municipio</label>
                                    <select name="municipio" id="municipio" class="form-control" required>
                                        <option value="">Seleccionar ...</option>
                                    </select>
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!--Contrasena -->
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Fecha de nacimiento  -->
                                <div class="form-group">
                                    <label for="fecha_nacimiento">Fecha de nacimiento *</label>
                                    <input type="date" name="fecha_nacimiento" max='' id="fecha_nacimiento"
                                        class="form-control" required>
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <!-- Fecha de nacimiento  -->
                                <div class="form-group">
                                    <label for="foto_paciente">Fotográfia </label>
                                    <input type="file" name="foto_paciente" id="foto_paciente" class="form-control"
                                        accept="image/*">
                                    <label class="invalid-feedback">Por favor, revisar el campo</label>
                                </div>
                            </div>

                            <div class="col-md-12 text-end">
                                <input type="submit" title="Guardar Doctor" class="btn btn-primary" value="Guardar"
                                    name="AgregarDoctores">
                                <a href="{{ route('doctor') }}" title="Regresar" class="btn btn-dark">Regresar</a>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
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

        });



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
