<?php

namespace Database\Seeders;

use App\Models\HealthcareProfessional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthcareProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HealthcareProfessional::insert([
            [
                'name' => 'Dr. Alice Smith',
                'specialty' => 'Cardiology',
            ],
            [
                'name' => 'Dr. Bob Johnson',
                'specialty' => 'Dermatology',
            ],
            [
                'name' => 'Dr. Carol Lee',
                'specialty' => 'Neurology',
            ],
        ]);
    }
}
