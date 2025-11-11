<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Jurusan',
            'email' => 'adminjurusan@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'admin_jurusan',
        ]);

        User::create([
            'name' => 'Admin FKIP',
            'email' => 'adminfkip@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'admin_FKIP',
        ]);

        User::create([
            'name' => 'Pimpinan FKIP',
            'email' => 'pimpinanfkip@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'pimpinan',
        ]);
    }
}
