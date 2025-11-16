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
            'name' => 'Admin Jurusan Pendidikan Komputer',
            'homebase' => 'Pendidikan Komputer',
            'email' => 'pilkom@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'admin_jurusan',
        ]);

        User::create([
            'name' => 'Admin Jurusan Pendidikan Ekonomi',
            'homebase' => 'Pendidikan Ekonomi',
            'email' => 'penko@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'admin_jurusan',
        ]);

        User::create([
            'name' => 'Admin 1 UPM FKIP ULM',
            'homebase' => 'UPM FKIP ULM',
            'email' => 'upmfkip1@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'admin_FKIP',
        ]);

        User::create([
            'name' => 'Admin 2 UPM FKIP ULM',
            'homebase' => 'UPM FKIP ULM',
            'email' => 'upmfkip2@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'admin_FKIP',
        ]);

        User::create([
            'name' => 'Pimpinan FKIP',
            'homebase' => 'FKIP',
            'email' => 'pimpinanfkip@ulm.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'pimpinan',
        ]);
    }
}
