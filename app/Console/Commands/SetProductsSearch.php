<?php

namespace App\Console\Commands;

use App\Models\PluginProducts;
use App\Models\PluginProductsCategoriesProducts;
use App\Models\PluginProductsLangs;
use App\Models\PluginProductsSearch;
use App\Models\ShopAttributesProducts;
use Illuminate\Console\Command;

class SetProductsSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:products_search {id=0} {--ids=}';

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
        $id = (int) $this->argument('id');
        $idsFromOption = $this->parseIdsOption($this->option('ids'));

        $shopSetting = \App\Models\ShopSettings::first();

        $runIncremental = count($idsFromOption) > 0;
        if (!$runIncremental && $id == 0) {
            PluginProductsSearch::truncate();
        } elseif ($runIncremental) {
            PluginProductsSearch::whereIn("plugin_product_id", $idsFromOption)->delete();
        } else {
            PluginProductsSearch::where("plugin_product_id", $id)->delete();
        }

        $query = PluginProducts::with("tax")->selectRaw("plugins_products.*")
            ->where("plugins_products.is_active", 1);

        if ($runIncremental) {
            $query->whereIn("id", $idsFromOption);
        } elseif ($id > 0) {
            $query->where("id", $id);
        }

        $processed = 0;
        $query->orderBy("id")->chunkById(200, function ($list) use ($shopSetting, &$processed) {
            if (!$list || $list->isEmpty()) {
                return;
            }

            $productIds = $list->pluck("id")->all();

            $categoriesMap = PluginProductsCategoriesProducts::whereIn("plugin_product_product_id", $productIds)
                ->get(["plugin_product_product_id", "plugin_product_category_id"])
                ->groupBy("plugin_product_product_id");

            $langsMap = PluginProductsLangs::whereIn("product_id", $productIds)
                ->where("is_active", 1)
                ->get(["product_id", "lang"])
                ->groupBy("product_id");

            $attributesMap = ShopAttributesProducts::whereIn("product_id", $productIds)
                ->get(["product_id", "attribute_id", "option_id"])
                ->groupBy("product_id");

            $rowsToInsert = [];
            foreach ($list as $item) {
                $brands = [$item->brand_id];
                $tags = [$item->tags];
                $attributes = [];
                $options = [];

                $categoriesRows = $categoriesMap->get($item->id, collect());
                $categories = $categoriesRows->pluck("plugin_product_category_id", "plugin_product_category_id")->toArray();

                $langRows = $langsMap->get($item->id, collect());
                $langs = $langRows->pluck("lang", "lang")->toArray();

                $attributesShop = $attributesMap->get($item->id, collect());
                foreach ($attributesShop as $attr) {
                    if (array_key_exists($attr->attribute_id, $attributes)) {
                        $attributes[$attr->attribute_id][] = $attr->option_id;
                    } else {
                        $attributes[$attr->attribute_id] = [];
                        $attributes[$attr->attribute_id][] = $attr->option_id;
                    }

                    $options[$attr->option_id] = $attr->option_id;
                }

                $promo_price = $item->getFinalPrice();

                $vet_ids = null;
                if ($item->is_variant == 0) {
                    $vet_ids = $item->get_vet_ids_search($shopSetting);
                }

                $rowsToInsert[] = [
                    "plugin_product_id" => $item->id,
                    "categories" => "," . implode(",", $categories) . ",",
                    "langs" => "," . implode(",", $langs) . ",",
                    "brands" => "," . implode(",", $brands) . ",",
                    "tags" => "," . implode(",", $tags) . ",",
                    "attributes" => count($attributes) ? json_encode($attributes) : null,
                    "options" => "," . implode(",", $options) . ",",
                    "price" => $promo_price,
                    "group_id" => $item->group_id,
                    "is_variant" => $item->is_variant,
                    "is_active" => $item->is_active,
                    "vet_ids_list" => json_encode($vet_ids),
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            }

            if ($rowsToInsert) {
                PluginProductsSearch::insert($rowsToInsert);
                $processed += count($rowsToInsert);
                $this->info("Indicizzazione prodotti: {$processed}");
            }
        });

        $this->info("Indicizzazione completata. Totale prodotti elaborati: {$processed}");
        return 0;
    }

    private function parseIdsOption($idsOption)
    {
        if (!$idsOption) {
            return [];
        }

        $parts = explode(",", (string) $idsOption);
        $ids = [];
        foreach ($parts as $part) {
            $id = (int) trim($part);
            if ($id > 0) {
                $ids[$id] = $id;
            }
        }

        return array_values($ids);
    }
}
