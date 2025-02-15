<?php
$lang = "IT";
return [
    'templates' => [
        "full_page" => "pagina unica",
        "sidebar_left" => "colonna sx - contenuto dx",
        "sidebar_right" => "contenuto sx - colonna dx",
        "three_columns" => "3 colonne"
    ],
    'templates_header' => [
        "row" => "singola riga",
        "two_cols" => "2 colonne",
        "three_cols" => "3 colonne",
    ],
    'templates_footer' => [
        "row" => "singola riga",
        "two_cols" => "2 colonne",
        "three_cols" => "3 colonne",
        "four_cols" => "4 colonne",
    ],
    'slugs_protected' => ["/admin/pluginProductsSettings/1/edit" => env("PLUGIN_PRODUCTS_URL_$lang")],
    "slug_shop_formula" => [env("SLUG_LOGIN"), env("SLUG_REGISTER"), env("SLUG_RECOVERY"), env("SLUG_CHANGE_PSW"), "myarea_dashboard", "myarea_profile", "myarea_orders", "myarea_subscriptions", "myarea_wishlist", "myarea_addresses",
        "myarea_companies", "myarea_support", "myarea_address", "myarea_company", env("SLUG_CART"), "checkout", "order_result","order_result_paypal","myarea_order_detail", "error_facebook"],
    "slug_plugin_booking" => [env("SLUG_LOGIN"), env("SLUG_REGISTER"), env("SLUG_RECOVERY"), env("SLUG_CHANGE_PSW"), "myarea_dashboard","myarea_profile", "myarea_reservations", "order_result", "order_result_paypal", "myarea_reservation_detail", "error_facebook"],
    "cart_rule_discount" => ["Amount - order" => "Amount - order" , "Percent - order" => "Percent - order"],
    "cart_rule_discount_promotion" => ["Amount" => "Amount" , "Percent" => "Percent"],
    "default_country_user_it" => 106,
    "default_country_user_dollar" => [1,2],
    "default_country_user_listino_2" => [109],
    "days" => [1 => "Lunedì", 2 => "Martedì", 3 => "Mercoledì", 4 => "Giovedì", 5 => "Venerdì", 6 => "Sabato", 7 => "Domenica"]
];
?>
