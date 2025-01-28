<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discountIds = DB::table("discounts")->pluck("id")->toArray();

        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Product::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 1, 1000),
                'stock' => $faker->numberBetween(1, 100),
                'discount_id' => $this->getRandomDiscountId($discountIds),
            ]);
        }
    }

    private function getRandomDiscountId(array $discountIds)
    {
        if (rand(0, 1) === 0) {
            return null;
        }

        return $discountIds[array_rand($discountIds)];
    }

}
