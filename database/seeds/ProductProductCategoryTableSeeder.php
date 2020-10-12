<?php

use Illuminate\Database\Seeder;

class ProductProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_product_category')->insert([
            'product_id' => 1,
            'product_category_id' => 1,
        ]);
    }
}
