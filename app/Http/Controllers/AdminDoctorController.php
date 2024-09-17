<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Log;





class AdminDoctorController extends Controller
{
    public function index()
    {
        try {
            // Obtener todos los usuarios que sean doctores
            $doctores = User::whereHas('role', function ($query) {
                $query->where('role_name', 'Doctor');
            })->get();

            // Pasar la colección de doctores a la vista
            return view('admin.doctor.index', ['doctores' => $doctores]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('doctor')->with('error', 'Error al cargar la página de AdminDoctores');
        }
    }


    public function create()
    {
        try {
            return view('admin.doctor.create');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('doctor')->with('error', 'Error al crear un doctor');
        }
    }

    public function detail()
    {
        try {
            return view('admin.doctor.detail');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('doctor')->with('error', 'Error al ver el detalle del doctor');
        }
    }

    public function edit($id)
    {
        try {
            $doctor = User::find($id);
            if (!$doctor) {
                // Handle the case when the patient is not found
                return redirect()->route('doctor')->with('error', 'Doctor no encontrado');
            }

            return view('admin.doctor.edit', ['doctor' => $doctor]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('doctor')->with('error', 'Error al editar al doctor');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {

                return redirect()->route('doctor')->with('error', 'Doctor no encontrado.');
            }

            $user->name = $request->input('nombre');
            $user->department = $request->input('departamento') == 'Seleccionar ...'
                ? $request->input('departamento_antiguo')
                : $request->input('departamento');

            $user->municipality = $request->input('municipio') == 'Seleccionar ...'
                ? $request->input('municipio_antiguo')
                : $request->input('municipio');

            $user->date_of_birth = $request->input('fecha_nacimiento');

            $user->img_path = !$request->hasFile('foto_paciente')
                ? $request->input('foto_paciente_guardada')
                : $this->subirImagen($user->carnet, $request);

            $user->save();

            return redirect()->route('doctor')->with('success', 'Doctor actualizado correctamente');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('doctor')->with('error', 'Error al actualizar al doctor');
        }
    }

    public function delete($id)
    {

        try {
            // Find the appointment by its ID and delete it
            $doctor = user::find($id);

            if (!$doctor) {
                return redirect()->route('doctor')->with('error', 'Doctor no encontrado');
            }

            $doctor->delete();

            return redirect()->route('doctor')->with('success', 'Doctor eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('doctor')->with('error', 'Error al borrar al doctor');
        }
    }

    public function report($id)
    {
        try {
            // Busca el médico por su id
            $doctor = User::findOrFail($id);

            // Carga la vista y pasa los datos a la vista
            $view = View::make('admin.doctor.report', compact('doctor'));
            $html = $view->render();

            $pdf = new Dompdf();
            $pdf->loadHtml($html);

            // Renderiza el PDF
            $pdf->render();

            // Devuelve el PDF para descargarlo
            return $pdf->stream('doctor_' . $id . '.pdf');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('doctor')->with('error', 'Error al crear el reporte');
        }
    }

    public function store(Request $request)
    {
        try {
            $user = new User();
            $request->validate([
                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'required|string|max:255',
                'numero_dui' => 'required|string|max:10',
                'municipio' => 'required|string|max:100',
                'departamento' => 'required|string|max:100',
                'email' => 'required|string|max:100',
                'fecha_nacimiento' => 'required|date',
                'foto_paciente' => 'image|mimes:jpeg,png,jpg,gif|max:30000', // Tamaño máximo de imagen: 2 MB
            ]);
            $existingUserDui = User::where('dui', $request->input('numero_dui'))->first();
            if ($existingUserDui) {
                return redirect()->back()->with('error', 'El número de DUI ya está registrado.');
            }
            // Verificar si el correo electrónico ya existe en la base de datos
            $existingUserEmail = User::where('email', $request->input('email'))->first();
            if ($existingUserEmail) {
                return redirect()->back()->with('error', 'El correo electrónico ya está registrado.');
            }
            $nombreIniciales = strtoupper(substr($request->input('primer_apellido'), 0, 1));
            $apellidoIniciales = strtoupper(substr($request->input('segundo_apellido'), 0, 1));
            // Generar valores aleatorios para el año y el número
            $anioAleatorio = rand(2000, 2025); // Cambiar los valores según el rango deseado para el año
            $numeroAleatorio = rand(100, 999); // Cambiar los valores según el rango deseado para el número
            // Combinar las iniciales con los valores aleatorios y formar el carnet
            $carnet = "{$anioAleatorio}-{$nombreIniciales}{$apellidoIniciales}-{$numeroAleatorio}";
            $user->dui = $request->input('numero_dui');
            $user->name = $request->input('primer_nombre') . ' ' . $request->input('segundo_nombre', '') . ' ' . $request->input('primer_apellido') . ' ' . $request->input('segundo_apellido', '');
            $user->carnet = $carnet;
            $user->department = $request->input('departamento');
            $user->municipality = $request->input('municipio');
            $user->date_of_birth = $request->input('fecha_nacimiento');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->img_path = null;
            if ($request->hasFile('foto_paciente')) {
                $image = $request->file('foto_paciente');
                $imageName =  $user->carnet . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/img', $imageName);

                $user->img_path = $imageName;
            }
            $user->role_id = 2;
            $user->status = 'A';
            $user->save();
            return redirect()->route('doctor')->with('success', 'Doctor agregado correctamente');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Por favor, revisar los campos');
        }
    }
}
