@extends('layouts/dashboardTemplate')

@section('title', 'Editar doctores')

@section('content')

    <!-- INICIO CONTENIDO -->
    <div class="card mt-3 mb-4">
        <div class="card-header fw-bold">
            Editar Doctor
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.doctor.update', ['id' => $doctor->user_id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <!-- Primer nombre -->
                                <div class="form-group">
                                    <label for="nombre">Nombre </label>
                                    <input type="text" name="nombre" id="nombre" class="form-control"
                                        value="{{ $doctor->name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Primer nombre -->
                                <div class="form-group">
                                    <label for="pass">Contraseña </label>
                                    <input type="password" name="pass" id="pass" class="form-control"
                                        value="">
                                </div>
                            </div>

                            <!-- DATOS GENERALES -->
                            <div class="col-md-6">
                                <!-- Numero de DUI -->
                                <div class="form-group">
                                    <label for="numero_dui">DUI </label>
                                    <input type="text" readonly name="numero_dui" id="numero_dui" class="form-control"
                                        value="{{ $doctor->dui }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Departamento -->
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <select name="departamento" id="departamento" class="form-control">
                                    </select>

                                    <input type="hidden" name="departamento_antiguo" id="departamento_antiguo"
                                        class="form-control" value="{{ $doctor->department }}">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Municipio -->
                                <div class="form-group">
                                    <label for="municipio">Municipio</label>
                                    <select name="municipio" id="municipio" class="form-control">
                                        <option value="{{ $doctor->municipality }}" hidden></option>
                                    </select>

                                    <input type="hidden" name="municipio_antiguo" id="municipio_antiguo"
                                        class="form-control" value="{{ $doctor->municipality }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Fecha de nacimiento  -->
                                <div class="form-group">
                                    <label for="fecha_nacimiento">Fecha de nacimiento *</label>
                                    <input type="date" name="fecha_nacimiento" max='' id="fecha_nacimiento"
                                        class="form-control" value="{{ $doctor->date_of_birth }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <!-- Fecha de nacimiento  -->
                                <div class="form-group">
                                    <label for="foto_doctor">Fotográfia </label>
                                    <input type="file" name="foto_doctor" id="foto_doctor" class="form-control"
                                        accept="image/*">
                                    <input type="hidden" name="foto_doctor_guardada" id="foto_doctor_guardada"
                                        class="form-control" value="{{ $doctor->img_path }}">
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <input type="submit" title="Guardar Doctor" class="btn btn-primary" value="Guardar"
                                    name="EditarDoctores">
                                <a href="{{ route('doctor') }}" title="Regresar" class="btn btn-dark">Regresar</a>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- FIN CONTENIDO -->


@endsection

@section('scripts')
    <script>
        const $departamento = document.getElementById('departamento');
        const $municipio = document.getElementById('municipio');
        const departamentoAlmacenado = document.getElementById('departamento_antiguo').value;
        const municipioAlmacenado = document.getElementById('municipio_antiguo').value;


        document.addEventListener('DOMContentLoaded', async () => {
            showLoadingModal('datos');

            // Cargar los departamentos
            await ajaxCountries({
                url: 'https://api.countrystatecity.in/v1/countries/SV/states',
                cbSuccess: async (json) => {
                    await loadDepartamentos({
                        departamentos: json,
                        departamentoGuardado: departamentoAlmacenado ?? null
                    });

                    // Verificar si hay una opción seleccionada en el select de departamentos
                    if ($departamento.selectedIndex !== -1) {
                        // Obtener el atributo 'data-iso2' del departamento seleccionado previamente
                        const selectedOption = $departamento.options[$departamento.selectedIndex];
                        const codigoDepartamento = selectedOption.getAttribute('data-iso2');

                        // Cargar los municipios del departamento seleccionado previamente
                        ajaxCountries({
                            url: `https://api.countrystatecity.in/v1/countries/SV/states/${codigoDepartamento}/cities`,
                            cbSuccess: async (json) => {
                                await loadMunicipios({
                                    municipios: json,
                                    municipioAlmacenado: municipioAlmacenado ??
                                        null
                                });
                                hideLoadingModal();
                            }
                        });
                    }

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
                        municipioAlmacenado: municipioAlmacenado ?? null
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
