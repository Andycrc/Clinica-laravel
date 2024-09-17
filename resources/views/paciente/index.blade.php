@extends('layouts/dashboardTemplate')

@section('title', 'Pacientes')

@section('content')
    <div class="card mt-4">
        <div class="card-header fw-bold">
            Administrar Pacientes
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-start mb-4">
                    <a href="{{ route('paciente.create') }}" title="Ingresar paciente" class="btn btn-primary icon-link">
                        Ingresar paciente
                    </a>
                </div>
                <div class="col-12 table-responsive">
                    <table
                        class="shadow-lg p-3 mb-5 bg-white rounded table table-striped table-bordered text-nowrap text-center"
                        id="tabla-ejemplo">
                        <thead>
                            <tr>
                                <th scope="col">Dui</th>
                                <th scope="col">Carnet</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Municipio</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-left text-wrap">
                            @foreach ($patients as $patient)
                                <tr>
                                    <td class="text-nowrap">{{ $patient->dui }}</td>
                                    <td class="text-nowrap">{{ $patient->carnet }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td class="text-nowrap">{{ $patient->email }}</td>
                                    <td>{{ $patient->department }}</td>
                                    <td>{{ $patient->municipality }}</td>
                                    <td>
                                        @if ($patient->img_path)
                                            <img src="{{ asset('storage/img/' . $patient->img_path) }}"
                                                alt="img-{{ $patient->carnet }}" class="img-thumbnail"
                                                style="max-width:60px">
                                        @else
                                            <img src="{{ asset('img/no_profile_pic.jpg') }}"
                                                alt="img-{{ $patient->carnet }}" class="img-thumbnail"
                                                style="max-width:60px">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('paciente.edit', ['id' => $patient->user_id]) }}"
                                            class="btn btn-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger" title="Eliminar"
                                            onclick="confirmDelete({{ $patient->user_id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
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
    function confirmDelete(user_id) {
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
                deletePatient(user_id);
            }
        });
    }

    function deletePatient(user_id) {
        const form = document.createElement('form');
        form.action = `/paciente/delete/${user_id}`;
        form.method = 'POST';
        form.innerHTML = `
            @csrf
            @method('delete')
        `;

        document.body.appendChild(form);
        form.submit();
    }
</script>
