<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        $this->call([
            MemberSeeder::class,
            ProductsSeeder::class,
            ProductCategorySeeder::class,
            ProductSubCategorySeeder::class,
            ProductSubCategoryAndProductSeeder::class,
            HomeSliderSeeder::class,
            HeadImgSeeder::class,
            NewsSeeder::class,
            PagesSeeder::class,
        ]);
    }
}
