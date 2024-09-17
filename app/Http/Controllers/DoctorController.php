<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __invoke()
    {
        return view('doctor.index');
    }

    public function Paciente()
    {
        return 'Index paciente';
    }
}
