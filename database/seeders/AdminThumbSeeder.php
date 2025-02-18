<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminThumbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dumps = Storage::disk('sqldumps');

        $check = \App\Models\AdminThumb::first();
        if(!$check){
            //\App\Models\AdminThumb::truncate();
            DB::unprepared($dumps->get('admin_thumbs.sql'));
        }
    }
}
