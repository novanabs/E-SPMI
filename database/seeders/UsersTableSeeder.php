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
        User::firstOrCreate([
            'email' => 'pilkom@ulm.ac.id',
        ], [
            'name'     => 'Dr. Harja Santana Purba, M.Kom.',
            'homebase' => 'Pendidikan Komputer',
            'nip'      => '123456789',
            'jabatan'  => 'Ketua Jurusan',
            'password' => Hash::make('12345'),
            'role'     => 'admin_jurusan',
        ]);

        User::firstOrCreate(
            [
                'email' => 'penko@ulm.ac.id',
            ],
            [
                'name'     => 'Dr. Muhammad Rahmattullah, M.Pd.',
                'nip'      => '987654321',
                'jabatan'  => 'Ketua Jurusan',
                'homebase' => 'Pendidikan Ekonomi',
                'password' => Hash::make('12345'),
                'role'     => 'admin_jurusan',
            ]
        );

        User::firstOrCreate([
            'email' => 'upmfkip1@ulm.ac.id',
        ], [
            'name'     => 'Admin 1 UPM FKIP ULM',
            'homebase' => 'UPM FKIP ULM',
            'password' => Hash::make('12345'),
            'role'     => 'admin_FKIP',
        ]);

        User::firstOrCreate([
            'email' => 'madhan@ulm.ac.id',
        ], [
            'name'     => 'Madhan, SPd.',
            'homebase' => 'Pendidikan Komputer',
            'password' => Hash::make('12345'),
            'jabatan'  => 'Auditor',
            'nip'      => '1122334455',
            'role'     => 'auditor',
        ]);

        User::firstOrCreate([
            'email' => 'ari@ulm.ac.id',
        ], [
            'name'     => 'Ari, SPd.',
            'homebase' => 'Pendidikan Komputer',
            'password' => Hash::make('12345'),
            'jabatan'  => 'Auditor',
            'nip'      => '5566778899',
            'role'     => 'auditor',
        ]);

        

        // User::firstOrCreate([
        //     'email' => 'upmfkip2@ulm.ac.id',
        // ], [
        //     'name' => 'Admin 2 UPM FKIP ULM',
        //     'homebase' => 'UPM FKIP ULM',
        //     'password' => Hash::make('12345'),
        //     'role' => 'admin_FKIP',
        // ]);

        User::firstOrCreate([
            'email' => 'pimpinanfkip@ulm.ac.id',
        ], [
            'name'     => 'Pimpinan FKIP',
            'homebase' => 'FKIP',
            'password' => Hash::make('12345'),
            'role'     => 'pimpinan',
        ]);
    }
}
