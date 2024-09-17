@extends('layouts/dashboardTemplate')

@section('title', 'Consulta')

@section('content')
    <div class="card mt-4">
        <div class="card-header fw-bold">
            Administrar consultas
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-start mb-4">
                    <a href="{{ route('consulta.create') }}" title="Crear consulta" class="btn btn-primary icon-link">
                        <i class="fas fa-plus"></i>
                        Agregar consulta
                    </a>
                </div>
                <div class="col-12 table-responsive">
                    <table
                        class="shadow-lg p-3 mb-5 bg-white rounded table table-striped table-bordered text-left text-wrap"
                        id="tabla-ejemplo">
                        <thead>
                            <tr>
                                <th scope="col">Paciente</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Diagnostico</th>
                                <th scope="col">Doctor</th>
                                <th scope="col">Proxima cita</th>
                                <th scope="col">Fecha de consulta</th>
                                <th scope="col">Acciones</th> <!-- New column for actions -->
                            </tr>
                        </thead>
                        <tbody class="text-left text-wrap">
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>{{ $appointment->description }}</td>
                                    <td>{{ $appointment->diagnosis }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->next_appointment }}</td>
                                    <td class="text-nowrap">
                                        {{ $appointment->created_at }}
                                    </td>

                                    <!-- Actions column with Edit and Delete buttons -->
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('consulta.edit', ['id' => $appointment->appointment_id]) }}"
                                                class="btn btn-primary mr-1" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger mr-1" title="Eliminar"
                                                onclick="confirmDelete({{ $appointment->appointment_id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <a href="{{ route('consulta.report', $appointment->appointment_id) }}"
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
        form.action = `/consulta/delete/${appointmentId}`;
        form.method = 'POST';
        form.innerHTML = `
            @csrf
            @method('delete')
        `;

        document.body.appendChild(form);
        form.submit();
    }
</script>
