<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{
    //

    public function __invoke()
    {
        $patients = User::whereNull('role_id')->orderBy('created_at', 'DESC')->get();
        return view('paciente.index', compact('patients'));
    }

    public function create()
    {

        return view('paciente.create');
    }

    public function detail()
    {

        return view('paciente.detail');
    }

    public function store(Request $request)
    {
        try {

            $user = new User();

            $existingUser = User::where('dui', $request->input('numero_dui'))->first();

            if ($existingUser) {
                return redirect()->back()->with('error', 'El DUI ingresado ya está registrado, intenta de nuevo.');
            }

            $request->validate([

                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'required|string|max:255',
                'numero_dui' => 'required|string|max:10',
                'municipio' => 'required|string|max:100',
                'departamento' => 'required|string|max:100',
                'fecha_nacimiento' => 'required|date',
                'foto_paciente' => 'image|mimes:jpeg,png,jpg,gif|max:30000', // Tamaño máximo de imagen: 2 MB
            ]);

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

            $user->email = $this->generateEmail($request->input('primer_nombre'), $request->input('primer_apellido'));

            $user->password = Hash::make('password');

            $user->img_path = $this->subirImagen($carnet, $request);

            $user->role_id = null;
            $user->status = 'A';

            $user->save();

            return redirect()->route('paciente')->with('success', 'Paciente agregado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('paciente')->with('error', 'Sucedio un error al agregar el paciente');
        }
    }

    protected function generateEmail($firstName, $lastName)
    {

        try {

            $firstName = strtolower($firstName);
            $lastName = strtolower($lastName);
            $emailDomain = 'clinica-sv.com';

            $username = $firstName . '.' . $lastName;

            return $username . rand(1, 100) . '@' . $emailDomain;
        } catch (\Throwable $th) {

            return redirect()->route('paciente')->with('success', 'Error al generar el email');
        }
    }

    public function buscarUsuarioPorDui(Request $request)
    {

        try {

            $dui = $request->input('numero_dui');

            // Buscar al usuario por DUI en la base de datos
            $user = User::where('dui', $dui)->first();

            if (!$user) {
                // Si el usuario no se encuentra, retornamos una respuesta JSON con mensaje de error
                return response()->json(['error' => 'No se encontró ningún usuario con el DUI proporcionado'], 404);
            }

            // Si se encuentra el usuario, retornamos los datos del usuario en formato JSON
            return response()->json(['user' => $user], 200);
        } catch (\Throwable $th) {
            return redirect()->route('paciente')->with('success', 'Paciente no encontrado');
        }
    }

    public function edit($id)
    {

        try {

            // Find the patient by its ID
            $patient = User::find($id);
            if (!$patient) {
                // Handle the case when the patient is not found
                return redirect()->route('paciente')->with('error', 'Paciente no encontrado');
            }

            return view('paciente.edit', ['patient' => $patient]);
        } catch (\Throwable $th) {

            return redirect()->route('paciente')->with('error', 'Error al agregar el paciente');
        }
    }


    public function update(Request $request, $id)
    {

        try {

            $user = User::find($id);

            if (!$user) {

                return redirect()->route('paciente')->with('error', 'Paciente no encontrado.');
            }

            $user->name = $request->input('nombre_completo');
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

            return redirect()->route('paciente')->with('success', 'Paciente actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('paciente')->with('error', 'Error al actualizar el paciente');
        }
    }

    public function delete($id)
    {

        try {


            // Find the patient by its ID and delete it
            $patient = User::find($id);
            if (!$patient) {
                return redirect()->route('paciente')->with('error', 'Paciente no encontrado');
            }

            $this->eliminarImagen($patient->img_path);

            $patient->delete();

            return redirect()->route('paciente')->with('success', 'Paciente eliminado correctamente');
        } catch (\Throwable $th) {

            return redirect()->route('paciente')->with('error', 'Error al eliminar el paciente');
        }
    }

    private function subirImagen($carnet, $request)
    {

        try {

            if (!$request->hasFile('foto_paciente')) return null;

            $image = $request->file('foto_paciente');
            $imageName = $carnet . '.' . $image->getClientOriginalExtension();

            $this->eliminarImagen($imageName);
            $image->storeAs('public/img', $imageName);

            return $imageName;
        } catch (\Throwable $th) {

            return redirect()->route('paciente')->with('error', 'Error al subir la foto del paciente');
        }
    }

    private function eliminarImagen($imageName)
    {
        try {


            $rutaImagen = 'public/img/' . $imageName;

            // Verificar si la imagen ya existe y eliminarla antes de guardar la nueva
            if (Storage::exists($rutaImagen)) {
                Storage::delete($rutaImagen);
                return 'Eliminada';
            }
            return 'No existe';
        } catch (\Throwable $th) {
            return redirect()->route('paciente')->with('error', 'Error al elimianr la foto');
        }
    }
}
