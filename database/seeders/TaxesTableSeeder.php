<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//\DB::table('shop_taxes')->truncate();

        $count = \DB::table('shop_taxes')->count();
        if($count == 0){
            $v_taxes = [0 => "Esente", "4" => "Iva 4%", 5 => "Iva 5%", 10 => "Iva 10%", 22 => "Iva 22%"];
            foreach ($v_taxes as $k=> $v){
                $check =  \DB::table('shop_taxes')->where("value", $k)->first();
                if(!$check){
                    $taxes = [
                        [
                            'name'  => $v,
                            'value' => $k,
                        ],
                    ];
                    \DB::table('shop_taxes')->insert($taxes);
                }
            }
        }

    }
}
