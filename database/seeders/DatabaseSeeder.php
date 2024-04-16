<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        //1. YONTEM
        // DB::table('categories')->insert(
        //     ['category_name'=>'Teknoloji']
        // );

        // 2. YONTEM

        $categories = [
            ['category_name'=>'Teknoloji'],
            ['category_name'=>'Sağlık'],
            ['category_name'=>'Eğitim'],
            ['category_name'=>'Spor']
        ];

        // VAR KONTROL (firstOrNew)

        foreach ($categories as $category) {


            $kayit = Category::firstOrNew($category);


            if(!$kayit->exists){
                Category::create($category);
            } else {
                $this->command->info('Kayıt bulunmaktadır.');
            }
        }


    }
}
