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
            'name'     => 'M Nabili',
            'homebase' => 'Pendidikan Komputer',
            'nip'      => '123456789',
            'jabatan'  => 'Operator Jurusan',
            'password' => Hash::make('12345'),
            'role'     => 'admin_jurusan',
        ]);

        User::firstOrCreate(
            [
                'email' => 'penko@ulm.ac.id',
            ],
            [
                'name'     => 'Admin Jurusan Pendidikan Ekonomi',
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
            'homebase' => 'Gugus Penjamin Mutu FKIP ULM',
            'password' => Hash::make('12345'),
            'jabatan'  => 'Auditor Internal',
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
