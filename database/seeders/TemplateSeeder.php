<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\AdminTemplate::truncate();

        /** inizio specifiche tema */

        \App\Models\AdminTemplate::where("name", "Basic")->delete();
        \App\Models\AdminTemplate::where("name", "Shoppy")->delete();
        \App\Models\AdminTemplate::where("name", "Creative")->delete();


        /** inizio specifiche tema */
        \App\Models\AdminTemplate::firstOrCreate(["name" => "Corporate1"],[
            "image_name" => "/imagesAdminTemplates/Corporate1.jpg",
            "url" => "https://www.witest.it/Corporate1/index.html",
            "price" => 900,
            "description" => "Template Grafico Responsive molto semplice, adatto per aziende che voglioni investire un budget limitato alla creazione del progetto web. Sviluppato con tecnologia Bootstrap 5."
        ]);
        /** fine specifiche tema */


        /** inizio specifiche tema */
        \App\Models\AdminTemplate::firstOrCreate(["name" => "Crafto"],[
            "image_name" => "/imagesAdminTemplates/Crafto.jpg",
            "url" => "https://www.witest.it/Crafto/index.html",
            "price" => 1250,
            "description" => "Template Grafico Responsive, adatto per la tua azienda in quanto ricco di personalizzazioni. Topbar per visualizzare Email e telefono, barra del menu e oltre 5 tipi di footer. Sviluppato con tecnologia Bootstrap 4."
        ]);
        /** fine specifiche tema */


        /** inizio specifiche tema */
        \App\Models\AdminTemplate::firstOrCreate(["name" => "Webshop"],[
            "image_name" => "/imagesAdminTemplates/Webshop.jpg",
            "url" => "https://www.witest.it/Proshop/demo10.html",
            "price" => 2000,
            "description" => "Template Grafico Responsive, adatto per la tua azienda in quanto ricco di personalizzazioni. Topbar per visualizzare Email e telefono, barra del menu e oltre 3 tipi di footer. Sviluppato con tecnologia Bootstrap 5."
        ]);
        /** fine specifiche tema */

    }
}
