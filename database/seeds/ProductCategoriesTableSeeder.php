<?php

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            'name' => 'Iron Deficiency Prevention Supplements',
            'slug' => 'iron-deficiency-prevention-supplements',
        ]);
    }
}
