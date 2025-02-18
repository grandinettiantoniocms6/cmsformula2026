<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AdminLanguage::firstOrCreate(["name" => "it"],[
               "label" => "Italiano",
               "name" => "it",
               "is_active" => 1,
               "is_frontend" => 1
        ]);

        \App\Models\AdminLanguage::firstOrCreate(["name" => "en"],[
            "label" => "Inglese",
            "name" => "en",
            "is_active" => 1,
            "is_frontend" => 1
        ]);

        \App\Models\AdminLanguage::firstOrCreate(["name" => "fr"],[
            "label" => "Francese",
            "name" => "fr",
            "is_active" => 0,
            "is_frontend" => 0
        ]);

        \App\Models\AdminLanguage::firstOrCreate(["name" => "es"],[
            "label" => "Spagnolo",
            "name" => "es",
            "is_active" => 0,
            "is_frontend" => 0
        ]);

    }
}
