<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentsTableSeeder extends Seeder
{
    protected $priority = 3;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generar 10 registros de citas utilizando la factory
        Appointment::factory(10)->create();
    }
}
