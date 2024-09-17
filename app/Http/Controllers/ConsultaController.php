<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

use Dompdf\Dompdf;


class ConsultaController extends Controller
{
    function __invoke()
    {
        try {
            $appointments = Appointment::with(['patient', 'doctor'])->get()->sortByDesc('created_at');
            return view('consulta.index', ['appointments' => $appointments]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error al cargar la página de listado de consultas');
        }
    }

    public function create()
    {
        try {
            return view('consulta.create');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error al cargar la página de creación de consulta');
        }
    }

    public function detail()
    {
        try {
            return view('consulta.detail');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error al cargar la página de detalles de consulta');
        }
    }
    function report($id)
    {
        try {
            // Busca la cita por ID, y si no se encuentra, lanza una excepción
            $appointment = Appointment::findOrFail($id);

            // Carga la vista y pasa los datos a la vista
            $view = View::make('consulta.report', compact('appointment'));
            $html = $view->render();

            $pdf = new Dompdf();
            $pdf->loadHtml($html);

            // Renderiza el PDF
            $pdf->render();

            // Devuelve el PDF para descargarlo
            return $pdf->stream('cita_' . $id . '.pdf');
        } catch (ModelNotFoundException $e) {
            // Manejo de la excepción si la cita no se encuentra
            return redirect()->route('consulta')->with('error', 'Cita no encontrada');
        } catch (\Exception $e) {
            // Manejo de otras excepciones
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error al generar el informe');
        }
    }
    public function edit($id)
    {
        try {
            // Find the appointment by its ID
            $appointment = Appointment::findOrFail($id);

            return view('consulta.edit', ['appointment' => $appointment]);
        } catch (ModelNotFoundException $e) {
            // Manejo de la excepción si la cita no se encuentra
            return redirect()->route('consulta')->with('error', 'Consulta no encontrada');
        } catch (QueryException $e) {
            // Manejo de excepciones SQL
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error de base de datos al editar la consulta');
        } catch (\Exception $e) {
            // Manejo de otras excepciones
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error al editar la consulta');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);

            $appointment->description = $request->input('description');
            $appointment->diagnosis = $request->input('diagnosis');
            $appointment->next_appointment = $request->input('next_appointment');
            // Add other fields if needed

            $appointment->save();

            return redirect()->route('consulta')->with('success', 'Consulta actualizada correctamente.');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('consulta')->with('error', 'Error al actualizar la consulta: ' . $ex->getMessage());
        } catch (\Exception $ex) {
            return redirect()->route('consulta')->with('error', 'Ocurrió un error inesperado: ' . $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Find the appointment by its ID and delete it
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return redirect()->route('consulta')->with('error', 'Consulta no encontrada');
            }

            $appointment->delete();

            return redirect()->route('consulta')->with('success', 'Consulta eliminada correctamente.');
        } catch (QueryException $e) {
            // Manejo de excepciones SQL
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error de base de datos al eliminar la consulta');
        } catch (\Exception $e) {
            // Manejo de otras excepciones
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error al eliminar la consulta');
        }
    }

    public function guardarConsulta(Request $request)
    {
        try {
            // Obtener los datos del formulario
            $paciente_id = $request->input('id_resultado');
            $descripcion = $request->input('descripcion');
            $diagnostico = $request->input('diagnostico');
            $next_appointment = $request->input('next_appointment');

            // Obtener el ID del doctor logueado
            $doctor_id = Auth::id();

            // Crear la nueva cita (appointment) con los datos proporcionados
            $consulta = new Appointment();
            $consulta->patient_id = $paciente_id;
            $consulta->doctor_id = $doctor_id;
            $consulta->description = $descripcion;
            $consulta->diagnosis = $diagnostico;
            $consulta->next_appointment = $next_appointment;
            // Puedes agregar más campos aquí si es necesario
            $consulta->save();

            // Redirigir a la vista de lista de consultas o mostrar un mensaje de éxito
            return redirect()->route('consulta')->with('success', 'Consulta médica creada exitosamente');
        } catch (QueryException $e) {
            // Manejo de excepciones SQL
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error de base de datos al crear la consulta médica');
        } catch (\Exception $e) {
            // Manejo de otras excepciones
            Log::error($e->getMessage());
            return redirect()->route('consulta')->with('error', 'Error al crear la consulta médica');
        }
    }
}
