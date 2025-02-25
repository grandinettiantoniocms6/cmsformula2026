<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dumps = Storage::disk('sqldumps');
        \DB::unprepared($dumps->get('cities-table.sql'));

        \App\Models\City::truncate();
        \DB::unprepared($dumps->get('cities-data.sql'));
    }
}
