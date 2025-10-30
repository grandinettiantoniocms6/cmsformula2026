<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //\App\Models\AdminBlock::truncate();

        \App\Models\AdminBlock::where("name", "blockContact")->delete();
        \App\Models\AdminBlock::where("name", "blockPortfolio")->delete();
        //\App\Models\AdminBlock::where("name", "blockPortfolio2")->delete();

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockHtml"],[
               "label" => "Html Testo libero",
               "name" => "blockHtml",
               "name_table" => "blocks_html",
               "is_active" => 1,
               "is_ordinable" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockImage"],[
            "label" => "Header pagina",
            "name" => "blockImage",
            "name_table" => "blocks_images",
            "is_active" => 1,
            "is_ordinable" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockSlideshow"],[
            "label" => "Slideshow",
            "name" => "blockSlideshow",
            "name_table" => "blocks_slideshows",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockNews"],[
            "label" => "News",
            "name" => "blockNews",
            "name_table" => "blocks_news",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);


        \App\Models\AdminBlock::firstOrCreate(["name" => "blockHero"],[
            "label" => "Hero",
            "name" => "blockHero",
            "name_table" => "blocks_heros",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockOnePhoto"],[
            "label" => "One Photo",
            "name" => "blockOnePhoto",
            "name_table" => "blocks_one_photos",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockDocument"],[
            "label" => "Lista documenti",
            "name" => "blockDocument",
            "name_table" => "blocks_documents",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockCarousel"],[
            "label" => "Carosello immagini",
            "name" => "blockCarousel",
            "name_table" => "blocks_carousels",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockSocial"],[
            "label" => "Social Network",
            "name" => "blockSocial",
            "name_table" => "blocks_socials",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockContactgmap"],[
            "label" => "Contatti e Google Map",
            "name" => "blockContactgmap",
            "name_table" => "blocks_contactgmaps",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockIcon"],[
            "label" => "Icone",
            "name" => "blockIcon",
            "name_table" => "blocks_icons",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockHtmlImage"],[
            "label" => "Html Testo libero + Carosello immagini",
            "name" => "blockHtmlImage",
            "name_table" => "blocks_htmlimages",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockImageLink"],[
            "label" => "HTML Testo libero + Immagine",
            "name" => "blockImageLink",
            "name_table" => "blocks_images_links",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockMetrox"],[
            "label" => "MetroX: Immagine e testo FullWidth a righe alterne",
            "name" => "blockMetrox",
            "name_table" => "blocks_metroxs",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockTab"],[
            "label" => "Tab",
            "name" => "blockTab",
            "name_table" => "blocks_tabs",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockParallax"],[
            "label" => "Sfondo Parallax",
            "name" => "blockParallax",
            "name_table" => "blocks_parallaxs",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockHightlight"],[
            "label" => "In Evidenza",
            "name" => "blockHightlight",
            "name_table" => "blocks_hightlights",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockGallery"],[
            "label" => "Galleria fotografica",
            "name" => "blockGallery",
            "name_table" => "blocks_gallerys",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPortfolio2"],[
            "label" => "Portfolio",
            "name" => "blockPortfolio2",
            "name_table" => "blocks_portfolio2s",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockReference"],[
            "label" => "Referenze",
            "name" => "blockReference",
            "name_table" => "blocks_references",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginProduct"],[
            "label" => "Catalogo Prodotti Plugin",
            "name" => "blockPluginProduct",
            "name_table" => "blocks_plugins_products",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginProductSearch"],[
            "label" => "Catalogo Prodotti - Cerca",
            "name" => "blockPluginProductSearch",
            "name_table" => "blocks_plugins_products_search",
            "is_active" => 0,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginProductLast"],[
            "label" => "Catalogo Prodotti - Ultimi inseriti",
            "name" => "blockPluginProductLast",
            "name_table" => "blocks_plugins_products_last",
            "is_active" => 0,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockVideobg"],[
            "label" => "Video Header",
            "name" => "blockVideobg",
            "name_table" => "blocks_videobgs",
            "is_active" => 0,
            "is_ordinable" => 0
        ]);


        \App\Models\AdminBlock::firstOrCreate(["name" => "blockFaq"],[
            "label" => "Faq",
            "name" => "blockFaq",
            "name_table" => "blocks_faqs",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginForm"],[
            "label" => "Form contatti PRO",
            "name" => "blockPluginForm",
            "name_table" => "blocks_plugins_forms",
            "is_active" => 1,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginCounter"],[
            "label" => "Contatore Plugin",
            "name" => "blockPluginCounter",
            "name_table" => "blocks_plugins_counters",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockBanner"],[
            "label" => "Banner",
            "name" => "blockBanner",
            "name_table" => "blocks_banners",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockScrollbar"],[
            "label" => "Scrollbar di immagini o elementi",
            "name" => "blockScrollbar",
            "name_table" => "blocks_scrollbars",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockMetro"],[
            "label" => "Metro",
            "name" => "blockMetro",
            "name_table" => "blocks_metros",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockHtmlTwocol"],[
            "label" => "HTML Testo libero su 2 colonne",
            "name" => "blockHtmlTwocol",
            "name_table" => "blocks_htmltwocols",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockCollage"],[
            "label" => "Collage",
            "name" => "blockCollage",
            "name_table" => "blocks_collages",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockFlusso"],[
            "label" => "Flusso - Contenuto numerato",
            "name" => "blockFlusso",
            "name_table" => "blocks_flussos",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockTimeline"],[
            "label" => "Timeline - Listato con data",
            "name" => "blockTimeline",
            "name_table" => "blocks_timelines",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockStaff"],[
            "label" => "Staff",
            "name" => "blockStaff",
            "name_table" => "blocks_staffs",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockVideotut"],[
            "label" => "Video Tutorial",
            "name" => "blockVideotut",
            "name_table" => "blocks_videotuts",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockLastwork"],[
            "label" => "Ultimi 6 Lavori",
            "name" => "blockLastwork",
            "name_table" => "blocks_lastworks",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockSeparator"],[
            "label" => "Separatore con Testo",
            "name" => "blockSeparator",
            "name_table" => "blocks_separators",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockStore"],[
            "label" => "Punti Vendita",
            "name" => "blockStore",
            "name_table" => "blocks_stores",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockBrand"],[
            "label" => "Brands/Marchi",
            "name" => "blockBrand",
            "name_table" => "blocks_brands",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPrice"],[
            "label" => "Prezzi/Price",
            "name" => "blockPrice",
            "name_table" => "blocks_prices",
            "is_active" => 0,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginBooking"],[
            "label" => "Blocco Plugin Booking",
            "name" => "blockPluginBooking",
            "name_table" => "blocks_plugins_booking",
            "is_active" => 0,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginCaccia"],[
            "label" => "Blocco Plugin Caccia",
            "name" => "blockPluginCaccia",
            "name_table" => "blocks_plugins_caccia",
            "is_active" => 0,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginTimetable"],[
            "label" => "Blocco Plugin Orari",
            "name" => "blockPluginTimetable",
            "name_table" => "blocks_plugins_timetables",
            "is_active" => 0,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockGrid"],[
            "label" => "Griglia di elementi",
            "name" => "blockGrid",
            "name_table" => "blocks_grids",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockListOfLink"],[
            "label" => "Elenco di Links",
            "name" => "blockListOfLink",
            "name_table" => "blocks_list_of_links",
            "is_active" => 1,
            "is_ordinable" => 1,
            "is_multi" => 1
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginBookingSearchType"],[
            "label" => "Blocco Plugin Booking Tipologia di prenotazione",
            "name" => "blockPluginBookingSearchType",
            "name_table" => "blocks_plugin_booking_search_types",
            "is_active" => 0,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);

        \App\Models\AdminBlock::firstOrCreate(["name" => "blockPluginParking"],[
            "label" => "Blocco Plugin Parking",
            "name" => "blockPluginParking",
            "name_table" => "blocks_plugin_parking",
            "is_active" => 0,
            "is_ordinable" => 0,
            "is_multi" => 0
        ]);


        // Nuove label dalla riga successiva

    }
}
