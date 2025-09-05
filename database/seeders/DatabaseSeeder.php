<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PeriodeSeeder::class,
            MahasiswaSeeder::class,
            AdminSeeder::class,
            LaporanMonevSeeder::class,
        ]);
    }
}
