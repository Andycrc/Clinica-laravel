<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence,
            'patient_id' => rand(1, 10), // Reemplaza esto con la lógica para seleccionar un paciente válido.
            'doctor_id' =>  rand(1, 10), // Reemplaza esto con la lógica para seleccionar un doctor válido.
            'diagnosis' => $this->faker->paragraph,
            'next_appointment' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
