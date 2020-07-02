<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'title' => 'Super Admin',
            'slug' => 'superadmin@email.com',
            'author_id' => '1',
            'excerpt' => 'Lorem ipsum dolor sit amet',
            'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ultrices metus quis vulputate pulvinar. Ut posuere nulla nec lacinia aliquet. Cras ut varius enim, luctus lobortis nisi. Pellentesque turpis nibh, pretium a est ut, feugiat tincidunt turpis. Morbi eleifend, nibh id finibus volutpat, neque sem hendrerit mauris, non volutpat ipsum sem et mi. Etiam quis massa nec mi imperdiet posuere. Mauris eu sem metus. Aliquam dignissim at mi a feugiat. Nulla eu risus sit amet ante gravida hendrerit at in nisl. Donec risus mauris, viverra ut cursus a, accumsan a velit.</p>',
            'status' => '1', //published
            'type' => '0',
            'banner' => '',
            'banner_mobile' => '',
            'published_at' => '2020-04-02 17:18:49',
            'created_at' => '2020-04-02 17:18:49',
            'updated_at' => '2020-04-02 17:18:49',
        ]);
    }
}
