<?php

use Illuminate\Database\Seeder;

class PluginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CATALOGO PRODOTTI
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginProducts"],[
               "label" => "Catalogo Prodotti",
               "name" => "pluginProducts",
               "icon" => "list",
               "version" => 1,
               "is_active" => 0
        ]);

        $check = \App\Models\PluginProductsSettings::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginProductsSettings::insert([
                "number_product" => 12
            ]);
        }

        $check = \App\Models\ShopSettings::where("id", 1)->first();
        if(!$check){
            \App\Models\ShopSettings::insert([
                "checkout" => 1,
                "visitors_buy" => 1,
                "role_default_register" => 5,
                "status_default_order" => 5,
                "status_default_nonpagato" => 5,
            ]);
        }

        $check = \App\Models\PluginProductsContacts::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginProductsContacts::insert([
                "name" => "contact"
            ]);
        }

        //FORMS
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginForms"],[
            "label" => "Plugin Form",
            "name" => "pluginForms",
            "icon" => "list",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginFormsSettings::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginFormsSettings::insert([
                "image" => null
            ]);
        }


        //ORDERS
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginOrders"],[
            "label" => "Gestione Ordini",
            "name" => "pluginOrders",
            "icon" => "calendar",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginOrdersSettings::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginOrdersSettings::insert([
                "name" => "Setting",
                "planning_start" => "08:00",
                "planning_end" => "21:00",
                "planning_slot" => "10",
                "planning_view" => "daily"
            ]);
        }

        /*$check = \App\Models\PluginOrdersStatuses::where("name", "Registrato")->first();
        if(!$check){
            \App\Models\PluginOrdersStatuses::insert([
                "name" => "Registrato",
                "color" => "#467fd0",
                "is_default" => 1,
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersStatuses::where("name", "In preparazione")->first();
        if(!$check){
            \App\Models\PluginOrdersStatuses::insert([
                "name" => "In preparazione",
                "color" => "#7c69ef",
                "is_default" => 0,
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersStatuses::where("name", "Pronto")->first();
        if(!$check){
            \App\Models\PluginOrdersStatuses::insert([
                "name" => "Pronto",
                "color" => "#384c74",
                "is_default" => 0,
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersStatuses::where("name", "Pronto per la spedizione")->first();
        if(!$check){
            \App\Models\PluginOrdersStatuses::insert([
                "name" => "Pronto per la spedizione",
                "color" => "#1b2a4e",
                "is_default" => 0,
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersStatuses::where("name", "Completato")->first();
        if(!$check){
            \App\Models\PluginOrdersStatuses::insert([
                "name" => "Completato",
                "color" => "#42ba96",
                "is_default" => 0,
                "user_id" => 1
            ]);
        }


        $check = \App\Models\PluginOrdersCategories::withTrashed()->where("name", "Postazione 1")->first();
        if(!$check){
            \App\Models\PluginOrdersCategories::insert([
                "name" => "Postazione 1",
                "color" => "#0040ff",
                "type_id" => 0,
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersCategories::withTrashed()->where("name", "Postazione 2")->first();
        if(!$check){
            \App\Models\PluginOrdersCategories::insert([
                "name" => "Postazione 2",
                "color" => "#bf4040",
                "type_id" => 0,
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersCategories::withTrashed()->where("name", "Categoria 1")->first();
        if(!$check){
            \App\Models\PluginOrdersCategories::insert([
                "name" => "Categoria 1",
                "color" => "#000000",
                "type_id" => 1,
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersClients::first();
        if(!$check){
            \App\Models\PluginOrdersClients::insert([
                "first_name" => "Paolo",
                "last_name" => "Rossi",
                "business_name" => "CmsFormula",
                "email" => "test@cmsformula.it",
                "mobile_1" => "0000000",
                "user_id" => 1
            ]);
        }

        $check = \App\Models\PluginOrdersProducts::first();
        if(!$check){
            \App\Models\PluginOrdersProducts::insert([
                "name" => "Prodotto 1",
                "plugin_order_category_id" => 2,
                "user_id" => 1
            ]);
        }*/

        //Tutorials
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginTutorials"],[
            "label" => "Tutorial",
            "name" => "pluginTutorials",
            "icon" => "youtube",
            "version" => 1,
            "is_active" => 1
        ]);

        //Counters
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginCounters"],[
            "label" => "Contatore",
            "name" => "pluginCounters",
            "icon" => "sort-numeric-up",
            "version" => 1,
            "is_active" => 0
        ]);

        //Invitations
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginInvitations"],[
            "label" => "Plugin Inviti",
            "name" => "pluginInvitations",
            "icon" => "list",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginInvitationsSettings::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginInvitationsSettings::insert([
                "email" => ""
            ]);
        }



        //Booking
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginBookings"],[
            "label" => "Plugin Booking",
            "name" => "pluginBookings",
            "icon" => "calendar",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginBookingSettings::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginBookingSettings::insert([
                "title" => ""
            ]);
        }


        //Booking
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginCaccia"],[
            "label" => "Plugin Caccia",
            "name" => "pluginCaccia",
            "icon" => "calendar",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginCacciaSettings::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginCacciaSettings::insert([
                "min_points" => 100
            ]);
        }

        //pluginTimetable
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginTimetable"],[
            "label" => "Plugin Orari",
            "name" => "pluginTimetable",
            "icon" => "calendar",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginTimetableSetting::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginTimetableSetting::insert([
                "color" => "#000000"
            ]);
        }

        //pluginParking
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginParking"],[
            "label" => "Plugin Parcheggio",
            "name" => "pluginParking",
            "icon" => "calendar",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginParkingSetting::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginParkingSetting::insert([
                "total_park_scoperto" => 150,
                "total_park_coperto" => 150
            ]);
        }


        //pluginInterventions
        \App\Models\AdminPlugin::firstOrCreate(["name" => "pluginIntervention"],[
            "label" => "Plugin Interventi",
            "name" => "pluginIntervention",
            "icon" => "calendar",
            "version" => 1,
            "is_active" => 0
        ]);

        $check = \App\Models\PluginInterventionsSetting::where("id", 1)->first();
        if(!$check){
            \App\Models\PluginInterventionsSetting::insert([
                "email" => "",
            ]);
        }

    }
}
