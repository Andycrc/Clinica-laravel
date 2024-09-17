@extends('layouts/dashboardTemplate')

@section('title', 'Editar Consulta')

@section('content')
    <div class="card mt-4">
        <div class="card-header fw-bold">
            Editar consulta
        </div>
        <div class="card-body">
            <form action="{{ route('consulta.update',['id' => $appointment->appointment_id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ $appointment->description }}">
                </div>
                <div class="mb-3">
                    <label for="diagnosis" class="form-label">Diagnóstico</label>
                    <input type="text" class="form-control" id="diagnosis" name="diagnosis" value="{{ $appointment->diagnosis }}">
                </div>
                <div class="mb-3">
                    <label for="next_appointment" class="form-label">Próxima cita</label>
                    <input type="date" class="form-control" id="next_appointment" name="next_appointment" value="{{ $appointment->next_appointment }}">
                </div>
                <!-- Add other fields if needed -->
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
@endsection
