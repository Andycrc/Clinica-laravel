<?php

namespace Database\Seeders;

use App\Models\MedicalPrescription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalPrescriptionsTableSeeder extends Seeder
{
    protected $priority = 4;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MedicalPrescription::factory(10)->create();
    }
}
