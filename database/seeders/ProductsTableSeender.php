<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeender extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // trancate the product table

      
        $faker = \Faker\Factory::create();


        for($i = 0; $i < 50; $i++) {
           Product::create([
            'name' => $faker->text(),
            'price' => $faker->randomDigit(),
            'description' =>$faker->paragraph(),
            'category' => $faker->text(),
            'countInStock' => $faker->randomDigit(),
            'brand' => $faker->text(),
            'user_id' => $faker->numberBetween(0,50),
            'image' => $faker->imageUrl($width = 200, $height = 200)
           ]);
        }
    }
}
