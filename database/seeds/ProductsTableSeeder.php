<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Maltofer® Tablet Kunyah',
            'slug' => 'maltofer-tablet-kunyah',
            'packaging' => 'Box, 5 strip @ 6 chewable',
            'composition' => 'Each chewable tablet contains 100 mg of iron as a complex of iron (III) -hidroksida polimaltosa',
            'overview' => 'For the treatment of latent iron deficiency and anemia (iron deficiency symptoms). Preventive treatment of iron deficiency to meet Dietary Allowances (RDA) during pregnancy',
            'instruction' => 'Treatment: Consult a doctor',
        ]);
    }
}
