@extends('layouts/dashboardTemplate')

@section('title', 'Admin/doctores')

@section('content')
    {{-- $_SESSION['username'] --}}
    <div class="card mt-4">
        <div class="card-header fw-bold">
            Administrar doctores
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-start mb-4">
                    <a title="Crear doctor" class="btn btn-primary icon-link" href="{{ route('admin.doctor.create') }}">
                        <i class="fas fa-plus"></i>
                        Ingresar doctor
                    </a>
                </div>
                <div class="col-12 table-responsive">
                    <table
                        class="shadow-lg p-3 mb-5 bg-white rounded table table-striped table-bordered text-nowrap text-center"
                        id="tabla-ejemplo">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">DUI</th>
                                <th scope="col">Carnet</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Fecha de nacimiento</th>
                                <th scope="col">Opciones</th>

                            </tr>
                        </thead>
                        <tbody class="text-left text-wrap">
                            <!-- PENDIENTE EL ARRAY -->
                            @foreach ($doctores as $doctor)
                                <tr>
                                    <td>{{ $doctor->name }}</td>
                                    <td>{{ $doctor->dui }}</td>
                                    <td>{{ $doctor->carnet }}</td>
                                    <td>{{ $doctor->municipality }}, {{ $doctor->department }}</td>
                                    <td>{{ $doctor->date_of_birth }}</td>
                                    <td>
                                        <div class="btn-group" role="group">

                                            <a href="{{ route('admin.doctor.edit', ['id' => $doctor->user_id]) }}"
                                                class="btn btn-primary mr-1" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger mr-1" title="Eliminar"
                                                onclick="confirmDelete({{ $doctor->user_id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <a href="{{ route('admin.doctor.report', $doctor->user_id) }}"
                                                class="btn btn-success" title="Generar PDF">
                                                <i class="fas fa-file-pdf"></i>

                                            </a>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete(appointmentId) {
        Swal.fire({
            title: '¿Estás seguro en eliminar este registro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
        }).then((result) => {
            if (result.isConfirmed) {
                deleteAppointment(appointmentId);
            }
        });
    }

    function deleteAppointment(appointmentId) {
        const form = document.createElement('form');
        form.action = `/doctor/delete/${appointmentId}`;
        form.method = 'POST';
        form.innerHTML = `
            @csrf
            @method('delete')
        `;

        document.body.appendChild(form);
        form.submit();
    }
</script>
