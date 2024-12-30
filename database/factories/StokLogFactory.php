<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StokLog>
 */
class StokLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'barang_id' => function () {
                return Barang::inRandomOrder()->first()->id; // Get an existing Barang ID
            },
            'description' => $this->faker->sentence(),
            'action' => $this->faker->randomElement(['added', 'subtracted']),
            'quantity' => $this->faker->numberBetween(1, 60),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($stokLog) {
            $barang = Barang::find($stokLog->barang_id);

            if ($barang) {
                // Calculate the new quantity based on the action
                $newQuantity = $stokLog->action === 'added'
                    ? $barang->quantity + $stokLog->quantity
                    : max(0, $barang->quantity - $stokLog->quantity); // Ensure non-negative quantity

                // Update the Barang record
                $barang->update(['quantity' => $newQuantity]);
            }
        });
    }
}
