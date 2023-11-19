<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use App\Models\Worker;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientRole = Role::findByName('Client');
        $workshopRole = Role::findByName('Workshop');
        $workerRole = Role::findByName('Worker');
        $clientUser = User::create([
            'name' => 'Client User',
            'email' => 'blumbergesteban@gmail.com',
            'password' => Hash::make('1234'),
        ]);

        $workshopUser = User::create([
            'name' => 'Workshop User',
            'email' => 'workshop@workshop.com',
            'password' => Hash::make('1234'),
        ]);
        $workerUser = User::create([
            'name' => 'Worker User',
            'email' => 'worker@worker.com',
            'password' => Hash::make('1234'),
        ]);
        $clientUser->assignRole($clientRole);
        $workshopUser->assignRole($workshopRole);
        $workerUser->assignRole($workerRole);
    }
}
