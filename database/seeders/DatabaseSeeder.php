<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            KriteriaSeeder::class,
            PenetapanSeeder::class,
            PelaksanaanSeeder::class,
            EvaluasiSeeder::class,
            PengendalianSeeder::class,
            PeningkatanSeeder::class,
            DokumenSeeder::class,
            LEDSeeder::class,
            LEDSeeder2::class,
            SubItemElemenSeeder::class,
            SyaratUnggulSeeder::class,
            PilkomEvaluationSeeder::class,
            AkreditasiSeeder::class
        ]);

    }
}
