<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\StokLog;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StokLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangIds = Barang::pluck('id'); 

        foreach ($barangIds as $barangId) {
            $addQuantity = 10; 
            $subtractQuantity = 5;  
            // $addQuantity = rand(5, 50); 
            // $subtractQuantity = rand(1, 30);  

            $barang = Barang::find($barangId);
            $barang->quantity += $addQuantity; 

            $barang->save();

            StokLog::create([
                'barang_id' => $barangId,
                'quantity' => $addQuantity,
                'action' => 'added',
                'description' => "Stock added. {$addQuantity} units were added to {$barang->name}.",
            ]);

            
            StokLog::create([
                'barang_id' => $barangId,
                'quantity' => $subtractQuantity,
                'action' => 'subtracted', 
                'description' => "Stock subtracted. {$subtractQuantity} units were removed from {$barang->name}.",
            ]);

            $barang->quantity -= $subtractQuantity;      
            $barang->save();
        }
    }
}
