<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BlockSeeder::class);

         $this->call(RolesSeeder::class);
         $this->call(PluginSeeder::class);
         $this->call(PluginLabelsSeeder::class);
         $this->call(LabelsSeeder::class);
         $this->call(LanguageSeeder::class);
         $this->call(TemplateSeeder::class);
         $this->call(TutorialsSeeder::class);

        //$this->call(CitiesSeeder::class);
        $this->call(CarriersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        //$this->call(TaxesTableSeeder::class);
        $this->call(OrderStatusesTableSeeder::class);

        //$this->call(AdminThumbSeeder::class);
    }
}
