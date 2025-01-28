<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1,6) as $index) {
            Discount::create([
                'percentage' => $faker->numberBetween(1, 50),
            ]);
        }
    }
}
