<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsBrands;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLangs;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesCategories;
use App\Models\ShopAttributesOptions;
use App\Models\ShopAttributesProducts;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportPlcClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:plc_client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      \DB::table("users")->where("id", ">", 1)->delete();
      \DB::table("model_has_roles")->where("role_id", 5)->delete();
        $list = \DB::connection('mysql_temp')
            ->table('users')
            ->join("role_users", "role_users.user_id", "=", "users.id")
            ->where("role_users.role_id", 2)
            ->where("users.active", 1)
            ->get();

        if($list){
            foreach ($list as $item){
                $type_client = 0;
                if($item->business_name){
                    $type_client = 1;
                }

                \DB::table("users")->insert([
                    "name" => $item->name,
                    "email" => $item->email,
                    "password" => $item->password,
                    "mobile" => $item->mobile,
                    "code" => $item->code,
                    "active" => 1,
                    "type_client" => $type_client,
                    "created_at" => Carbon::now()->toDateTimeString()
                ]);

                $client = \DB::table("users")->where("email", $item->email)->first();

                \DB::table("model_has_roles")->insert([
                    "role_id" => 5,
                    "model_id" => $client->id,
                    "model_type" => "App\User"
                ]);

                $this->info("users $item->name");
            }
        }

    }
}
