<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
use App\Models\StokLog;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\UserFactory;
use Database\Factories\BarangFactory;
use Database\Factories\StokLogFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BarangSeeder::class,
            StokLogSeeder::class,
            UserSeeder::class,
        ]);

        User::factory()->count(20)->create();
        Barang::factory()->count(10)->create();
        StokLog::factory()->count(200)->create();
    }
}
