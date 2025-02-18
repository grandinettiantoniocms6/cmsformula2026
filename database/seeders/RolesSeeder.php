<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = \DB::table('roles')->where("name", "SuperAdmin")->first();
        if(!$check){
            DB::table('roles')->insert([
                "name" => "SuperAdmin",
                "guard_name" => "web"
            ]);
        }

        $check = \DB::table('roles')->where("name", "Amministratore")->first();
        if(!$check){
            DB::table('roles')->insert([
                "name" => "Amministratore",
                "guard_name" => "web"
            ]);
        }

        $check = \DB::table('roles')->where("name", "Editore")->first();
        if(!$check){
            DB::table('roles')->insert([
                "name" => "Editore",
                "guard_name" => "web"
            ]);
        }

        $check = \DB::table('roles')->where("name", "Lettore")->first();
        if(!$check){
            DB::table('roles')->insert([
                "name" => "Lettore",
                "guard_name" => "web"
            ]);
        }

        $check = \DB::table('users')->where("id", 1)->first();
        if(!$check){
            $check = \DB::table('users')->where("email", "info@webisland.it")->first();
            if(!$check){
                \DB::table('users')->insert([
                    "name" => "Webisland",
                    "email" => "info@webisland.it",
                    "password" => bcrypt("12345678"),
                    "created_at" => \Carbon\Carbon::now()->toDateTimeString()
                ]);
            }
        }

        $check = \DB::table('model_has_roles')->where("role_id", 1)->first();
        if(!$check){
            \DB::table('model_has_roles')->insert([
                "role_id" => 1,
                "model_type" => "App\User",
                "model_id" => 1
            ]);
        }

        $check = \DB::table('website_settings')->where("id", 1)->first();
        if(!$check){
            \DB::table('website_settings')->insert([
                "title" => "CmsFormula",
                "number_max_page" => 200,
                "is_online" => 0,
                "created_at" => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        }


        $check = \App\Models\Page::where("is_homepage", 1)->first();
        if(!$check){
            \App\Models\Page::create([
                "name" => "Home",
                "title" => "Home",
                "slug" => "/",
                "is_in_menu" => 1,
                "is_active" => 1,
                "template" => "full_page",
                "template_header" => "row",
                "template_footer" => "three_cols",
                "parent_id" => null,
                "is_homepage" => 1,
                "title_page" => "Homepage"
            ]);

        }
    }
}
