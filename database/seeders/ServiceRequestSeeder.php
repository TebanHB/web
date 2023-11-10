<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $location = "-17.805413367274696, -63.19319806263701";

        ServiceRequest::create([
            'location' => $location,
            'date'=> now(),
            'description' => 'casa del negro',
            'status' => 'pending',
            'client_id' => 1,
            // Add other fields as necessary
        ]);
    }
}
