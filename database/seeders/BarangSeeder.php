<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'name' => 'PC Angkasa Pura Support i3-8100',
            'description' => 'PC Angkasa Pura Support dengan prosesor Intel Core i3-8100',
            'quantity' => 0,
        ]);

        Barang::create([
            'name' => 'Monitor LG 24MK430H',
            'description' => 'Monitor LG 24MK430H dengan layar 24 inci',
            'quantity' => 0,
        ]);
    }
}
