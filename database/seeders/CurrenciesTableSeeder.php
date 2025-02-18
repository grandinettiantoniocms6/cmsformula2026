<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('shop_currencies')->truncate();

    	$currencies = [
    		[
                'name'  => '€',
                'iso'  => 'EUR',
                'value' => '1',
				'default'  => '1',
    		],
            [
                'name'  => '$',
                'iso'  => 'DOL',
                'value' => '2',
                'default'  => '0',
            ],
    	];

    	DB::table('shop_currencies')->insert($currencies);
    }
}
