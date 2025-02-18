<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('shop_order_statuses')->truncate();

    	$statuses = [
    		[
                'name'  => 'In lavorazione',
                'className'  => 'warning',
    		],
            [
                'name'  => 'Processato',
                'className'  => 'primary',
            ],
            [
                'name'  => 'Spedito',
                'className'  => 'success',
            ],
            [
                'name'  => 'Completato',
                'className'  => 'success',
            ],
            [
                'name'  => 'Non pagato',
                'className'  => 'danger',
            ],
            [
                'name'  => 'Annullato',
                'className'  => 'danger',
            ],
    	];

    	DB::table('shop_order_statuses')->insert($statuses);
    }
}
