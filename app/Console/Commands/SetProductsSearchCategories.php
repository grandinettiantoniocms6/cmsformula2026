<?php

namespace App\Console\Commands;

use App\Models\PluginCategoriesSearch;
use App\Models\PluginProducts;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsCategoriesSearch;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLangs;
use App\Models\PluginProductsSearch;
use App\Models\ShopAttributes;
use App\Models\ShopAttributesProducts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetProductsSearchCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:products_categories_search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categories = \App\Models\PluginProductsCategories::where("is_active", 1)
            ->where("parent_id", null)
            ->where("is_purchasable", 1)
            ->orderBy("lft", "asc")
            ->get();

        $class = new \App\Http\Controllers\PluginProductsController();
        $categories = $class->get_categories_sidebar($categories);

        // ✔ controlla se la collection NON è vuota
        if ($categories && $categories->isNotEmpty()) {

            PluginProductsCategoriesSearch::truncate();

            PluginProductsCategoriesSearch::create([
                "categories" => json_encode($categories)
            ]);

            $this->info("Categorie aggiornate correttamente.");

        } else {

            $this->warn("Nessuna categoria trovata. Truncate non eseguito.");
        }

    }
}
