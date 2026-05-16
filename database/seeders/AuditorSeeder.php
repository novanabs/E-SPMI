<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'novan@ulm.ac.id',
        ], [
            'name'     => 'Novan',
            'homebase' => 'Auditor',
            'password' => Hash::make('12345'),
            'role'     => 'auditor',
        ]);

        User::firstOrCreate([
            'email' => 'nanda@ulm.ac.id',
        ], [
            'name'     => 'Nanda',
            'homebase' => 'Auditor',
            'password' => Hash::make('12345'),
            'role'     => 'auditor',
        ]);

        User::firstOrCreate([
            'email' => 'rizki@ulm.ac.id',
        ], [
            'name'     => 'Rizki',
            'homebase' => 'Auditor',
            'password' => Hash::make('12345'),
            'role'     => 'auditor',
        ]);

        User::firstOrCreate([
            'email' => 'wira@ulm.ac.id',
        ], [
            'name'     => 'Wira',
            'homebase' => 'Auditor',
            'password' => Hash::make('12345'),
            'role'     => 'auditor',
        ]);
    }
}
