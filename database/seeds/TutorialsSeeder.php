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

            $url = "https://gest.webisland.it/tutorials.xml";
            $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

            if($xml->channel){
                foreach ($xml->channel as $tutorial){
                    echo "$tutorial->title";

                    $check = \App\Models\PluginTutorial::where("url", $tutorial->description)->first();
                    if($check){
                        $check->from_gest = 1;
                        $check->save();
                    }

                    \App\Models\PluginTutorial::firstOrCreate(["url" => $tutorial->description],[
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
