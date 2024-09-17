<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'dui' => $this->faker->unique()->regexify('[0-9]{7}-[0-9]{1}'),
            'carnet' => $this->faker->unique()->regexify('^\d{4}-[A-Z]{2}-\d{3}$'),
            'department' => 'Santa Ana',
            'municipality' => $this->faker->city(),
            'date_of_birth' => $this->faker->date(),
            'email' => $this->faker->email(),
            'role_id' => rand(1, 2),
            'status' => 'A',
            'img_path' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
