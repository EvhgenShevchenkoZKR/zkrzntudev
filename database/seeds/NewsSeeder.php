<?php

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=NewsSeeder

        $newsToCreate = 187;


        $title = "Стара новина";
        $body = "Стара новина";
        $zkrZNTU = "Запорізький коледж радіоелектроніки ЗНТУ";

        //2016-09-04 12:57:30

        for ($i = 0; $i < $newsToCreate; $i++) {
            DB::table('news')->insert([ //,
                'title' => $title,
                'body' => $body,
                'published' => true,
                'important' => false,
                'author_id' => 3,
                'cover_image' => '',
                'cover_show' => false,
                'cover_title' => $zkrZNTU,
                'cover_alt' => $zkrZNTU,
                'meta_title' => $zkrZNTU,
                'meta_keywords' => $zkrZNTU,
                'meta_description' => $zkrZNTU,
                'author_name' => 'Життя коледжу',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]);
        }
    }
}

