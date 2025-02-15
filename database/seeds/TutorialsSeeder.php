<?php

use Illuminate\Database\Seeder;

class TutorialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\PluginTutorial::truncate();

        try{
            \App\Models\PluginTutorial::where("from_gest", 1)->delete();

            $tutorials = \DB::connection('mysql_2')->table('tutorials')
                ->whereNull("deleted_at")
                ->orderBy("id", "asc")
                ->get();

            if($tutorials){
                foreach ($tutorials as $tutorial){
                    $check = \App\Models\PluginTutorial::where("url", $tutorial->url)->first();
                    if($check){
                        $check->from_gest = 1;
                        $check->save();
                    }

                    \App\Models\PluginTutorial::firstOrCreate(["url" => $tutorial->url],[
                        "title" => $tutorial->title,
                        "from_gest" => 1
                    ]);
                }
            }
        }catch (\Throwable $e) {
           echo $e->getMessage();
        }


        // fINE

    }
}
