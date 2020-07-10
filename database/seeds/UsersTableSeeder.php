<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@email.com',
            'password' => bcrypt('password'),
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('password'),
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
        ]);
        DB::table('users')->insert([
            'name' => 'Editor',
            'email' => 'editor@email.com',
            'password' => bcrypt('password'),
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
        ]);
        DB::table('users')->insert([
            'name' => 'Author',
            'email' => 'author@email.com',
            'password' => bcrypt('password'),
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
        ]);
        DB::table('users')->insert([
            'name' => 'contributor',
            'email' => 'contributor@email.com',
            'password' => bcrypt('password'),
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
        ]);
        DB::table('users')->insert([
            'name' => 'Subscriber',
            'email' => 'subscriber@email.com',
            'password' => bcrypt('password'),
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
        ]);
    }
}
