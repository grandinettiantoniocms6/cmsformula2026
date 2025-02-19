<?php
$lang = \App::getLocale();

use App\Models\AdminLanguage;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('/test/email/order', function() {
    //'order' => $order, 'send_psw' => $send_psw, 'code_psw'=>$code_psw, 'user'=> $user
    $order = \App\Models\Order::first();
    $user = \App\User::first();
    $send_psw = 0;
    $code_psw = "aaa";
    $html = view("common.emails.order", compact('order','user', 'send_psw', 'code_psw'))->render();
    die($html);

});

Route::get('/test/email/contact', function() {
    $data = ["request" => [
        "first_name" => "Keivan"
    ]];

    $html = view("common.emails.contact", compact('data'))->render();
    die($html);

});


Route::group(['prefix' => config('backpack.base.route_prefix'), 'middleware' => ['admin'], 'namespace' => 'Admin'], function()
{
    Route::get('/dashboard', ['as' => 'dashboard', 'uses'=>'DashboardController@index']);
    Route::get('/access/{id}', ['as' => 'access', 'uses'=>'DashboardController@access']);
    Route::get('/delete_image_special/{id}', ['as' => 'delete_image_special', 'uses'=>'DashboardController@delete_image_special']);


    Route::post('actions',['as' => 'actions', 'uses'=>'DashboardController@actions']);

    Route::post('/pluginInterventions/get_client', ['as' => 'pluginInterventions.get_client', 'uses'=>'PluginInterventionsClientsCrudController@get_client']);
    Route::any('plugin/pluginInterventions/monitor',['as' => 'pluginInterventions.monitor', 'uses'=>'PluginInterventionsCrudController@monitor']);
    Route::get('/pluginInterventions/printPDF/{id}',['as' => 'pluginInterventions.print_pdf', 'uses'=>'PluginInterventionsCrudController@print_pdf']);
    Route::get('/pluginInterventions/sendPDF/{id}',['as' => 'pluginInterventions.send_mail', 'uses'=>'PluginInterventionsCrudController@send_mail']);
    Route::get('/pluginInterventions/annulla/{id}',['as' => 'pluginInterventions.annulla', 'uses'=>'PluginInterventionsCrudController@annulla']);
    Route::any('plugin/pluginInterventions/check',['as' => 'check.pluginInterventions', 'uses'=>'PluginInterventionsCrudController@check']);
    Route::any('plugin/shopAttributes/check',['as' => 'check.shopAttributes', 'uses'=>'ShopAttributesCrudController@check']);


    Route::get('/pluginOrders/planning', ['as' => 'PluginOrder.planning', 'uses'=>'PluginOrdersCrudController@planning']);
    Route::get('/pluginOrders/planning/events', ['as' => 'planning.events', 'uses'=>'PluginOrdersCrudController@events']);
    Route::post('/pluginOrders/planning/drop_and_resize', ['as' => 'planning.drop_and_resize', 'uses'=>'PluginOrdersCrudController@drop_and_resize']);

    Route::post('/pluginOrders/planning/open_reservation_new', ['as' => 'planning.open_reservation_new', 'uses'=>'PluginOrdersCrudController@open_reservation_new']);
    Route::post('/pluginOrders/planning/open_reservation', ['as' => 'planning.open_reservation', 'uses'=>'PluginOrdersCrudController@open_reservation']);

    Route::any('/pluginOrders/client/autocomplete', ['as' => 'PluginOrder.clients_autocomplete', 'uses'=>'PluginOrdersClientsCrudController@autocomplete']);
    Route::post('/pluginOrders/get_client', ['as' => 'PluginOrder.get_client', 'uses'=>'PluginOrdersClientsCrudController@get_client']);
    Route::post('/pluginOrders/get_row_products', ['as' => 'PluginOrder.get_row_products', 'uses'=>'PluginOrdersProductsCrudController@get_row_products']);
    Route::post('/pluginOrders/add_new_products', ['as' => 'PluginOrder.add_new_products', 'uses'=>'PluginOrdersProductsCrudController@add_new_products']);
    Route::post('/pluginOrders/delete_reservation', ['as' => 'PluginOrder.delete_reservation', 'uses'=>'PluginOrdersCrudController@delete_reservation']);
    Route::get('/pluginOrders/printPDF/{id}',['as' => 'PluginOrder.print_pdf', 'uses'=>'PluginOrdersCrudController@print_pdf']);

    Route::any('/pluginOrders/store_from_planning', ['as' => 'PluginOrder.store_from_planning', 'uses'=>'PluginOrdersCrudController@store_from_planning']);
    Route::any('/pluginOrders/update_from_planning', ['as' => 'PluginOrder.update_from_planning', 'uses'=>'PluginOrdersCrudController@update_from_planning']);

    Route::get('/pluginOrders/events', ['as' => 'pluginOrders.events', 'uses'=>'PluginOrdersCrudController@events']);

    Route::get('/pluginTutorial/view', ['as' => 'pluginTutorial.view', 'uses'=>'PluginTutorialCrudController@view']);

    Route::get('/tutorials', ['as' => 'tutorials', 'uses'=>'DashboardController@tutorials']);
    Route::get('changeEnv/{key}/{value}', ['as'=>'putPermanentEnv', 'uses'=>'DashboardController@putPermanentEnv']);
    Route::post('changeTemplate', ['as'=>'changeTemplate', 'uses'=>'DashboardController@changeTemplate']);

    Route::get('dropzone','ImageUploadController@index');

    Route::get('image/upload','ImageUploadController@fileCreate');
    Route::post('image/upload/store','ImageUploadController@fileStore');
    Route::post('image/delete','ImageUploadController@fileDestroy');
    Route::post('image/reorder', ['as' => 'reorderProductImages', 'uses' => 'ImageUploadController@reorder']);

    Route::post('/sanitize_string', ['as' => 'sanitize_string', 'uses'=>'DashboardController@sanitize_string']);
    Route::get('/eredita/{id}', ['as' => 'eredita', 'uses'=>'DashboardController@eredita']);
    Route::get('/attivazione/{id}', ['as' => 'attivazione', 'uses'=>'DashboardController@attivazione']);

    Route::get('/setBoolean/{table}/{id}/{field}/{value}', ['as' => 'dashboard.set.field.boolean', 'uses'=>'DashboardController@set_field_boolean']);

    Route::get('/block/order/{type}/{id}', ['as' => 'dashboard', 'uses'=>'DashboardController@order_list']);

    Route::get('/pages_blocks/{page}', ['as' => 'pages.blocks', 'uses'=>'DashboardController@pages_blocks']);
    Route::post('/pages_blocks/{page}/switch', ['as' => 'pages.blocks.switch', 'uses'=>'DashboardController@pages_blocks_switch']);
    Route::put('/pages_blocks/{page}/saveOrder', ['as' => 'pages.blocks.saveOrder', 'uses'=>'DashboardController@pages_blocks_save_order']);
    Route::put('/pages_blocks/{type}/{id}/saveOrder/singleBlock', ['as' => 'pages.blocks.saveOrder.single.block', 'uses'=>'DashboardController@pages_blocks_save_order_single_block']);

    Route::get('/pages_blocks/{page}/block/{id}/delete', ['as' => 'pages.blocks.delete', 'uses'=>'DashboardController@pages_blocks_delete']);

    Route::get('plugin/pluginProducts/import_export',['as' => 'pluginProducts.import_export', 'uses'=>'PluginProductsCrudController@import_export']);
    Route::post('plugin/pluginProducts/export',['as' => 'pluginProducts.export', 'uses'=>'PluginProductsCrudController@export']);
    Route::post('plugin/pluginProducts/import',['as' => 'pluginProducts.import', 'uses'=>'PluginProductsCrudController@import']);
    Route::post('plugin/pluginProducts/import_maison',['as' => 'pluginProducts.import_maison', 'uses'=>'PluginProductsCrudController@import_maison']);
    Route::post('plugin/pluginProducts/create_combinations',['as' => 'pluginProducts.create_combinations', 'uses'=>'PluginProductsCrudController@create_combinations']);
    Route::post('plugin/pluginProducts/associate_combinations',['as' => 'pluginProducts.associate_combinations', 'uses'=>'PluginProductsCrudController@associate_combinations']);

    Route::get('pluginProductsRequests/{id}/print',['as' => 'pluginProducts.request.print', 'uses'=>'PluginProductsRequestsCrudController@print_pdf']);
    Route::get('pluginFormsRequests/{id}/print',['as' => 'pluginForms.request.print', 'uses'=>'PluginFormsRequestsCrudController@print_pdf']);

    // Update Order Status
    Route::post('orders/update-status', ['as' => 'updateOrderStatus', 'uses' => 'ShopOrdersCrudController@updateStatus']);
    Route::post('orders/update-order-payment', ['as' => 'updateOrderPayment', 'uses' => 'ShopOrdersCrudController@updateOrderPayment']);
    Route::post('orders/update-save-tracking', ['as' => 'saveOrderTrackingCode', 'uses' => 'ShopOrdersCrudController@saveTracking']);
    Route::post('orders/delete-order', ['as' => 'deleteOrder', 'uses' => 'ShopOrdersCrudController@deleteOrder']);
    Route::post('orders/send-message', ['as' => 'sendOrderMessage', 'uses' => 'ShopOrdersCrudController@sendMessage']);

    Route::get('/shopOrders/printPDF/{id}',['as' => 'shopOrders.print_pdf', 'uses'=>'ShopOrdersCrudController@print_pdf']);
    Route::get('/shopOrders/printExcel/{id}',['as' => 'shopOrders.export_excel', 'uses'=>'ShopOrdersCrudController@export_excel']);

    Route::post('plugin/pluginProducts/actions',['as' => 'pluginsProducts.actions', 'uses'=>'PluginProductsCrudController@actions']);
    Route::post('plugin/pluginProductsBrands/actions',['as' => 'pluginsProductsBrands.actions', 'uses'=>'PluginProductsBrandsCrudController@actions']);
    Route::post('plugin/pluginProductsCategories/actions',['as' => 'pluginsProductsCategories.actions', 'uses'=>'PluginProductsCategoriesCrudController@actions']);

    Route::post('plugin/pluginProductsRequests/actions',['as' => 'pluginProductsRequests.actions', 'uses'=>'PluginProductsRequestsCrudController@actions']);

    Route::post('plugin/pluginFormsRequests/actions',['as' => 'pluginFormsRequests.actions', 'uses'=>'PluginFormsRequestsCrudController@actions']);
    Route::post('users/actions',['as' => 'users.actions', 'uses'=>'CustomUserCrudController@actions']);

    Route::get('/pluginInvitations/resend/{id}', ['as' => 'pluginInvitations.resend', 'uses'=>'PluginInvitationsCrudController@resend']);

    Route::get('/pluginBookings/planning', ['as' => 'pluginBookings.planning', 'uses'=>'PluginBookingReservationCrudController@planning']);
    Route::get('/pluginBookings/get-url', 'PluginBookingReservationCrudController@getUrl')->name('getUrl');
    Route::get('/pluginBookings/events', ['as' => 'pluginBookings.events', 'uses'=>'PluginBookingReservationCrudController@events']);
    Route::get('/pluginBookings/get-service-info', ['as' => 'pluginBookings.get-service-info', 'uses'=>'PluginBookingServicesCrudController@get_info']);

    Route::get('/pluginBookings/generate_pin/{id}', ['as' => 'pluginBookings.generate_pin', 'uses'=>'PluginBookingReservationCrudController@generate_pin']);
    Route::get('/pluginBookings/send_pin/{id}', ['as' => 'pluginBookings.send_pin', 'uses'=>'PluginBookingReservationCrudController@send_pin']);
    Route::get('/pluginBookings/send_sollecito/{id}', ['as' => 'pluginBookings.send_sollecito', 'uses'=>'PluginBookingReservationCrudController@send_sollecito']);

    Route::post('plugin/pluginCaccia/actions',['as' => 'pluginCaccia.actions', 'uses'=>'PluginCacciaHuntersCrudController@actions']);
    Route::any('plugin/pluginCaccia/graduatoria',['as' => 'pluginCaccia.graduatoria', 'uses'=>'PluginCacciaHuntersCrudController@graduatoria']);
    Route::get('plugin/pluginCaccia/import',['as' => 'pluginCaccia.import', 'uses'=>'PluginCacciaHuntersCrudController@import']);
    Route::post('plugin/pluginCaccia/import_save',['as' => 'pluginCaccia.import_save', 'uses'=>'PluginCacciaHuntersCrudController@import_save']);

    Route::any('plugin/pluginParking/panoramica',['as' => 'pluginParking.panoramica', 'uses'=>'PluginParkingReservationCrudController@panoramica']);
    Route::any('plugin/pluginParking/monitor',['as' => 'pluginParking.monitor', 'uses'=>'PluginParkingReservationCrudController@monitor']);

    Route::post('plugin/pluginParking/save_holidays',['as' => 'pluginParking.save_holidays', 'uses'=>'PluginParkingSettingCrudController@save_holidays']);

    Route::get('plugin/pluginParking/sync',['as' => 'pluginParking.sync', 'uses'=>'PluginParkingSettingCrudController@sync']);

    Route::post('plugin/pluginInterventions/actions',['as' => 'pluginInterventions.actions', 'uses'=>'PluginInterventionsCrudController@actions']);
    Route::post('plugin/pluginInterventions/change_delivery',['as' => 'pluginInterventions.change_delivery', 'uses'=>'PluginInterventionsCrudController@change_delivery']);
    // Add change_annullato > Annullato by Antonio G.
    Route::post('plugin/pluginInterventions/change_annullato',['as' => 'pluginInterventions.change_annullato', 'uses'=>'PluginInterventionsCrudController@change_annullato']);


});

// QUI SE DOVESSE SERVIRE VADO A SCRIVERE GI EVENTUALI REDIRECT 301 (invece di scriverli sul file htaccess)
// la prima parte eri, è il vecchio url la destination è il nuovo url
Route::redirect('/soluzioni/siti-web-cms-formula', '/creazione-siti-web', 301);
Route::redirect('/home2020', '/', 301);

// PLUGIN PRODUCTS V3 - SHOP FORMULA

Route::get('/', ['as' => 'index', 'uses'=>'IndexController@index']);
Route::get('/paypal_test', ['as' => 'paypal_test', 'uses'=>'IndexController@paypal_test']);
Route::get('/parkos', ['as' => 'parkos', 'uses'=>'ParkosController@index']);
Route::get('/email_test', ['as' => 'email_test', 'uses'=>'IndexController@email_test']);

Route::get('sitemap.xml','SitemapController@index');
Route::get('404', ['as' => 'page_not_found', 'uses'=>'IndexController@page_not_found']);
Route::get('results', ['as' => 'results', 'uses'=>'IndexController@results']);
Route::get('news', ['as' => 'news', 'uses'=>'IndexController@news']);

if(env('SLUG_COMPARE')){
    Route::get(env('SLUG_COMPARE'), ['as' => 'comparatore', 'uses'=>'PluginProductsController@comparatore']);
}

Route::get('/add_compare/{id}', ['as' => 'advice.compare', 'uses'=>'PluginProductsController@advice_compare']);
Route::get('/remove_compare/{id}', ['as' => 'advice.compare.remove', 'uses'=>'PluginProductsController@advice_compare_remove']);

Route::get(env('SLUG_LOGIN'), ['as' => 'login', 'uses'=>'IndexController@login']);
Route::get(env('SLUG_REGISTER'), ['as' => 'register', 'uses'=>'IndexController@register'])->middleware(ProtectAgainstSpam::class);
Route::get(env('SLUG_RECOVERY'), ['as' => 'recovery_password', 'uses'=>'IndexController@recovery_password']);
Route::get(env('SLUG_CHANGE_PSW').'/{code}', ['as' => 'index.changePassword', 'namespace' => 'Front', 'uses'=>'IndexController@change_password']);
Route::get('order_result', ['as' => 'order.result', 'uses' => 'CartController@order_result']);
Route::get('order_result_paypal', ['as' => 'order.result.paypal.payment', 'uses' => 'CartController@order_result_paypal_payment']);

Route::get('email_order_test', ['as' => 'order.email_order_test', 'uses' => 'CartController@email_order_test']);

//REGISTPRAZIONE E LOGIN
Route::get('auth/{provider}', 'AccountController@redirectToProvider');
Route::get('auth/{provider}/callback', 'AccountController@handleProviderCallback');
Route::get('xml/facebook', array('as' => 'xml.facebook','uses' => 'XmlController@facebook'));

Route::get('error_facebook', array('as' => 'error_facebook','uses' => 'AccountController@error_facebook'));
Route::post('google_sign', ['as' => 'google_sign', 'uses' => 'AccountController@google_sign']);
Route::post('/registerProcess', ['as' => 'index.registerProcess', 'namespace' => 'Front', 'uses'=>'AccountController@registerProcess']);
Route::post('/registerProcessFull', ['as' => 'index.registerProcessFull', 'namespace' => 'Front', 'uses'=>'AccountController@registerProcessFull']);

Route::post('/loginProcess', ['as' => 'index.loginProcess', 'namespace' => 'Front', 'uses'=>'AccountController@loginProcess']);
Route::get('/activate/{code}', ['as' => 'index.activate', 'namespace' => 'Front', 'uses'=>'AccountController@activate']);
Route::get('/login/{code}', ['as' => 'index.autologin', 'namespace' => 'Front', 'uses'=>'AccountController@auto_login_subscriptions']);

Route::get('/logout', ['as' => 'logout', 'namespace' => 'Front', 'uses'=>'AccountController@logout']);
Route::post('/changePasswordProcess', ['as' => 'index.changePasswordProcess', 'namespace' => 'Front', 'uses'=>'AccountController@changePasswordProcess']);
Route::post('/recoveryProcess', ['as' => 'index.recoveryProcess', 'namespace' => 'Front', 'uses'=>'AccountController@recoveryProcess']);

Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'AddMoneyController@payWithPaypal'));
Route::any('paypal', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal'));
Route::post('paypal-transaction-complete', array('as' => 'paypal-transaction-complete','uses' => 'AddMoneyController@paypal_transaction_complete'));
Route::post('paypal-transaction-complete-booking', array('as' => 'paypal-transaction-complete-booking','uses' => 'AddMoneyController@paypal_transaction_complete_booking'));
Route::post('paypal-transaction-error', array('as' => 'paypal-transaction-error','uses' => 'AddMoneyController@paypal_transaction_error'));

//MyArea
\Route::group(['prefix' => 'myarea', 'middleware' => ['myarea']], function () {
    Route::get('/dashboard', ['as' => 'myarea.dashboard', 'namespace' => 'Front', 'uses' => 'MyAreaController@dashboard']);
    Route::get('/profile', ['as' => 'myarea.profile', 'namespace' => 'Front', 'uses' => 'MyAreaController@profile']);

    Route::get('/order_detail', ['as' => 'order.detail', 'uses' => 'MyAreaController@order_detail']);
    Route::post('order-edit-payment', ['as' => 'order.edit.payment', 'uses' => 'MyAreaController@order_edit_payment']);

    Route::get('/wishlist', ['as' => 'myarea.wishlist', 'namespace' => 'Front', 'uses' => 'MyAreaController@wishlist']);
    Route::post('/remove-wishlist', ['as' => 'myarea.delete_wishlist', 'namespace' => 'Front', 'uses' => 'MyAreaController@wishlistDelete']);
    Route::post('/add-wishlist', ['as' => 'myarea.add_wishlist', 'namespace' => 'Front', 'uses'=>'MyAreaController@WishlistAdd']);
    Route::get('/remove-wishlist-list', ['as' => 'myarea.delete_wishlist_list', 'namespace' => 'Front', 'uses' => 'MyAreaController@wishlistDeleteList']);

    Route::get('/pay/{id}', ['as' => 'myarea.pay', 'namespace' => 'Front', 'uses' => 'MyAreaController@pay']);
    Route::get('/orders', ['as' => 'myarea.orders', 'namespace' => 'Front', 'uses' => 'MyAreaController@orders']);
    Route::get('/subscriptions', ['as' => 'myarea.subscriptions', 'namespace' => 'Front', 'uses' => 'MyAreaController@subscriptions']);

    Route::get('/support', ['as' => 'myarea.support', 'namespace' => 'Front', 'uses' => 'MyAreaController@support']);
    Route::post('/profileProcess', ['as' => 'myarea.profileProcess', 'namespace' => 'Front', 'uses' => 'MyAreaController@profileProcess']);

    Route::get('/addresses', ['as' => 'myarea.addresses', 'namespace' => 'Front', 'uses' => 'MyAreaController@addresses']);
    Route::get('/address/{id?}', ['as' => 'myarea.address', 'namespace' => 'Front', 'uses' => 'MyAreaController@address']);
    Route::post('/address_save', ['as' => 'myarea.address_save', 'namespace' => 'Front', 'uses' => 'MyAreaController@address_save']);
    Route::get('/address_delete/{id}', ['as' => 'myarea.address_delete', 'namespace' => 'Front', 'uses' => 'MyAreaController@address_delete']);

    Route::get('/companies', ['as' => 'myarea.companies', 'namespace' => 'Front', 'uses' => 'MyAreaController@companies']);
    Route::get('/company/{id?}', ['as' => 'myarea.company', 'namespace' => 'Front', 'uses' => 'MyAreaController@company']);
    Route::post('/company_save', ['as' => 'myarea.company_save', 'namespace' => 'Front', 'uses' => 'MyAreaController@company_save']);
    Route::get('/company_delete/{id}', ['as' => 'myarea.company_delete', 'namespace' => 'Front', 'uses' => 'MyAreaController@company_delete']);
    Route::post('/message_save', ['as' => 'myarea.message_save', 'namespace' => 'Front', 'uses' => 'MyAreaController@message_save']);

    Route::get('/reservations', ['as' => 'myarea.reservations', 'namespace' => 'Front', 'uses' => 'MyAreaController@reservations']);
    Route::get('/reservation_detail', ['as' => 'reservation.detail', 'uses' => 'MyAreaController@reservation_detail']);

});

//AJAX
\Route::group(['prefix' => 'ajax'], function () {
    Route::get('/test', ['as' => 'ajax.test', 'uses' => 'AjaxController@test']);

    Route::any('/product/detail', ['as' => 'get.product_detail', 'uses' => 'AjaxController@product_detail']);
    Route::post('/product/variants_list', ['as' => 'get.product_variant_list', 'uses' => 'AjaxController@product_variant_list']);

    Route::post('/get_cities_by_province', ['as' => 'get.cities_by_province', 'uses' => 'AjaxController@get_cities_by_province']);
    Route::post('/get_shippings_by_cities', ['as' => 'get.shippings_by_cities', 'uses' => 'AjaxController@get_shippings_by_cities']);
    Route::post('/get_shippings', ['as' => 'get.shippings', 'uses' => 'AjaxController@get_shippings']);
    Route::get('/api/cities', 'AjaxController@get_cities');
    Route::post('/get_second_attribute_detail_product', ['as' => 'get_second_attribute_detail_product', 'uses' => 'AjaxController@get_second_attribute_detail_product']);

    Route::post('/check_code_coupon', ['as' => 'check.code_coupon', 'uses' => 'AjaxController@code_coupon']);
    Route::post('/uncheck_code_coupon', ['as' => 'uncheck.code_coupon', 'uses' => 'AjaxController@uncheck_code_coupon']);

    Route::post('checkout/get_box_shippings_checkout', ['as' => 'ajax.checkout.get_box_shippings_checkout', 'uses' => 'AjaxController@get_box_shippings_checkout']);
    Route::post('checkout/get_box_fatturazione_checkout', ['as' => 'ajax.checkout.get_box_fatturazione_checkout', 'uses' => 'AjaxController@get_box_fatturazione_checkout']);
    Route::post('checkout/get_box_payments_checkout', ['as' => 'ajax.checkout.get_box_payments_checkout', 'uses' => 'AjaxController@get_box_payments_checkout']);
    Route::post('checkout/get_info_for_method_shippings_checkout', ['as' => 'ajax.checkout.get_info_for_method_shippings_checkout', 'uses' => 'AjaxController@get_info_for_method_shippings_checkout']);
    Route::post('checkout/new_address_checkout', ['as' => 'ajax.checkout.new_address_checkout', 'uses' => 'AjaxController@new_address_checkout']);
    Route::post('checkout/delete_address_checkout', ['as' => 'ajax.checkout.delete_address_checkout', 'uses' => 'AjaxController@delete_address_checkout']);
    Route::post('checkout/new_fatturazione_checkout', ['as' => 'ajax.checkout.new_fatturazione_checkout', 'uses' => 'AjaxController@new_fatturazione_checkout']);
    Route::post('checkout/delete_fatturazione_checkout', ['as' => 'ajax.checkout.delete_fatturazione_checkout', 'uses' => 'AjaxController@delete_fatturazione_checkout']);
    Route::post('checkout/get_address_checkout', ['as' => 'ajax.checkout.get_address_checkout', 'uses' => 'AjaxController@get_address_checkout']);
    Route::post('checkout/get_fatturazione_checkout', ['as' => 'ajax.checkout.get_fatturazione_checkout', 'uses' => 'AjaxController@get_fatturazione_checkout']);
    Route::post('checkout/get_fields_custom_checkout', ['as' => 'ajax.checkout.get_fields_custom_checkout', 'uses' => 'AjaxController@get_fields_custom_checkout']);



    Route::post('/plugin_parking/send_request', ['as' => 'plugin_parking.send_request', 'uses' => 'PluginParkingController@send_request'])->middleware(ProtectAgainstSpam::class);
    Route::post('/plugin_parking/calculate_price', ['as' => 'plugin_parking.calculate_price', 'uses' => 'PluginParkingController@calculate_price']);

});

//API
\Route::group(['prefix' => 'api'], function () {
    Route::get('/cities', 'Api\CityController@cities');
    Route::get('/category', 'Api\CategoryController@index');
    Route::get('/category/{id}', 'Api\CategoryController@show');
    Route::get('/brand', 'Api\BrandController@index');
    Route::get('/brand/{id}', 'Api\BrandController@show');
    Route::get('/product', 'Api\ProductController@index');
    Route::get('/product/{id}', 'Api\ProductController@show');
    Route::get('/productGroup', 'Api\ProductGroupController@index');
    Route::get('/productGroup/{id}', 'Api\ProductGroupController@show');
});

//Cart
\Route::group(['prefix' => 'cart'], function () {
    Route::get('/', ['as' => 'cart', 'uses' => 'CartController@cart']);
    Route::post('update-cart', ['as' => 'update.cart', 'uses' => 'CartController@update_cart']);
    Route::get('/remove-cart-list', ['as' => 'remove.cart.list', 'namespace' => 'Front', 'uses' => 'CartController@remove_cart_list']);
    Route::post('add-cart-product', ['as' => 'add.cart.product', 'uses' => 'CartController@add_to_cart_from_product']);
    Route::get('add-cart-product-search', ['as' => 'add.cart.product.search', 'uses' => 'CartController@add_to_cart_from_product_search']);

    Route::post('add-cart-product-multiple', ['as' => 'add.cart.product.multiple', 'uses' => 'CartController@add_to_cart_from_product_multiple']);

    Route::get('/checkout', ['as' => 'checkout', 'uses' => 'CartController@checkout']);
    Route::post('save-order-new', ['as' => 'save.order_new', 'uses' => 'CartController@save_order_new']);
});


// News
Route::get('news/{slug}', ['as' => 'news.slug', 'uses'=>'IndexController@news_slug']);
Route::get('preview_news/{slug}', ['as' => 'preview_news.slug', 'uses'=>'IndexController@preview_news']);

Route::get('news/tag/{tag}', ['as' => 'news.tag', 'uses'=>'IndexController@news_tag']);
Route::get('news/category/{category}', ['as' => 'news.category', 'uses'=>'IndexController@news_category']);

Route::post('contact_form/send', ['as'=>'contact_form.send', 'uses'=>'IndexController@contact_form_send']);
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'IndexController@switchLang']);

Route::get("pluginTimetables/{id}", ['as' => "pluginTimetables.pdf", 'uses'=>'PluginTimetablesController@createPdf']);


//PLUGIN ROUTES
// PLUGIN BOOKING
$url_plugin_booking = env("PLUGIN_BOOKING_URL_IT");
if($url_plugin_booking) {
    \Route::group(['prefix' => $url_plugin_booking], function () {
        Route::post("/hidden", ['as' => "pluginBookingHidden.it", 'uses' => 'PluginBookingController@hidden', 'middleware' => ['plugin_booking']]);

        Route::any("/", ['as' => "pluginBooking.it", 'uses' => 'PluginBookingController@index', 'middleware' => ['plugin_booking']]);
        Route::any("choose_type", ['as' => "pluginBooking.choose_type.it", 'uses' => 'PluginBookingController@choose_type', 'middleware' => ['plugin_booking']]);
        Route::any("get_camere", ['as' => "pluginBooking.get_rooms.it", 'uses' => 'PluginBookingController@get_rooms', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi", ['as' => "pluginBooking.get_services.it", 'uses' => 'PluginBookingController@get_services', 'middleware' => ['plugin_booking']]);
        Route::post("set_partecipanti", ['as' => "pluginBooking.set_partecipants.it", 'uses' => 'PluginBookingController@set_partecipants', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi_2", ['as' => "pluginBooking.get_services_2.it", 'uses' => 'PluginBookingController@get_services_2', 'middleware' => ['plugin_booking']]);
        Route::post("get_checkout", ['as' => "pluginBooking.get_checkout.it", 'uses' => 'PluginBookingController@get_checkout', 'middleware' => ['plugin_booking']]);
        Route::post("checkout", ['as' => "pluginBooking.checkout.it", 'uses' => 'PluginBookingController@checkout', 'middleware' => ['plugin_booking']]);
        Route::post("save_order", ['as' => "pluginBooking.save_order.it", 'uses' => 'PluginBookingController@save_order', 'middleware' => ['plugin_booking']]);
        Route::post("save_documents", ['as' => "pluginBooking.save_documents.it", 'uses' => 'PluginBookingController@save_documents', 'middleware' => ['plugin_booking']]);

        Route::get("register", ['as' => "pluginBooking.register.it", 'uses' => 'PluginBookingController@register', 'middleware' => ['plugin_booking']]);
        Route::get("activate/{code}", ['as' => "pluginBooking.activate.it", 'uses' => 'PluginBookingController@activate', 'middleware' => ['plugin_booking']]);
        Route::get("riassume", ['as' => "pluginBooking.riassume.it", 'uses' => 'PluginBookingController@riassume', 'middleware' => ['plugin_booking']]);
        Route::get("order/{id}", ['as' => "pluginBooking.order.it", 'uses' => 'PluginBookingController@order', 'middleware' => ['plugin_booking']]);
        Route::any("404", ['as' => "pluginBooking.404.it", 'uses' => 'PluginBookingController@not_found', 'middleware' => ['plugin_booking']]);
    });
}

$url_plugin_booking = env("PLUGIN_BOOKING_URL_EN");
if($url_plugin_booking){
    \Route::group(['prefix' => $url_plugin_booking], function () {
        Route::post("/hidden", ['as' => "pluginBookingHidden.en", 'uses' => 'PluginBookingController@hidden', 'middleware' => ['plugin_booking']]);

        Route::any("/", ['as' => "pluginBooking.en", 'uses'=>'PluginBookingController@index', 'middleware' => ['plugin_booking']]);
        Route::post("/choose_type", ['as' => "pluginBooking.choose_type.en", 'uses'=>'PluginBookingController@choose_type', 'middleware' => ['plugin_booking']]);
        Route::post("get_camere", ['as' => "pluginBooking.get_rooms.en", 'uses'=>'PluginBookingController@get_rooms', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi", ['as' => "pluginBooking.get_services.en", 'uses'=>'PluginBookingController@get_services', 'middleware' => ['plugin_booking']]);
        Route::post("set_partecipanti", ['as' => "pluginBooking.set_partecipants.en", 'uses'=>'PluginBookingController@set_partecipants', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi_2", ['as' => "pluginBooking.get_services_2.en", 'uses'=>'PluginBookingController@get_services_2', 'middleware' => ['plugin_booking']]);
        Route::post("get_checkout", ['as' => "pluginBooking.get_checkout.en", 'uses'=>'PluginBookingController@get_checkout', 'middleware' => ['plugin_booking']]);
        Route::post("checkout", ['as' => "pluginBooking.checkout.en", 'uses'=>'PluginBookingController@checkout', 'middleware' => ['plugin_booking']]);
        Route::post("save_order", ['as' => "pluginBooking.save_order.en", 'uses'=>'PluginBookingController@save_order', 'middleware' => ['plugin_booking']]);
        Route::post("save_documents", ['as' => "pluginBooking.save_documents.en", 'uses'=>'PluginBookingController@save_documents', 'middleware' => ['plugin_booking']]);

        Route::get("register", ['as' => "pluginBooking.register.en", 'uses'=>'PluginBookingController@register', 'middleware' => ['plugin_booking']]);
        Route::get("activate/{code}", ['as' => "pluginBooking.activate.en", 'uses'=>'PluginBookingController@activate', 'middleware' => ['plugin_booking']]);
        Route::get("riassume", ['as' => "pluginBooking.riassume.en", 'uses'=>'PluginBookingController@riassume', 'middleware' => ['plugin_booking']]);
        Route::get("order/{id}", ['as' => "pluginBooking.order.en", 'uses'=>'PluginBookingController@order', 'middleware' => ['plugin_booking']]);
        Route::any("404", ['as' => "pluginBooking.404.en", 'uses' => 'PluginBookingController@not_found', 'middleware' => ['plugin_booking']]);

    });
}

$url_plugin_booking = env("PLUGIN_BOOKING_URL_DE");
if($url_plugin_booking){
    \Route::group(['prefix' => $url_plugin_booking], function () {
        Route::any("/", ['as' => "pluginBooking.de", 'uses'=>'PluginBookingController@index', 'middleware' => ['plugin_booking']]);
        Route::post("/choose_type", ['as' => "pluginBooking.choose_type.de", 'uses'=>'PluginBookingController@choose_type', 'middleware' => ['plugin_booking']]);
        Route::post("get_camere", ['as' => "pluginBooking.get_rooms.de", 'uses'=>'PluginBookingController@get_rooms', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi", ['as' => "pluginBooking.get_services.de", 'uses'=>'PluginBookingController@get_services', 'middleware' => ['plugin_booking']]);
        Route::post("set_partecipanti", ['as' => "pluginBooking.set_partecipants.de", 'uses'=>'PluginBookingController@set_partecipants', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi_2", ['as' => "pluginBooking.get_services_2.de", 'uses'=>'PluginBookingController@get_services_2', 'middleware' => ['plugin_booking']]);
        Route::post("get_checkout", ['as' => "pluginBooking.get_checkout.de", 'uses'=>'PluginBookingController@get_checkout', 'middleware' => ['plugin_booking']]);
        Route::post("checkout", ['as' => "pluginBooking.checkout.de", 'uses'=>'PluginBookingController@checkout', 'middleware' => ['plugin_booking']]);
        Route::post("save_order", ['as' => "pluginBooking.save_order.de", 'uses'=>'PluginBookingController@save_order', 'middleware' => ['plugin_booking']]);
        Route::post("save_documents", ['as' => "pluginBooking.save_documents.de", 'uses'=>'PluginBookingController@save_documents', 'middleware' => ['plugin_booking']]);

        Route::get("register", ['as' => "pluginBooking.register.de", 'uses'=>'PluginBookingController@register', 'middleware' => ['plugin_booking']]);
        Route::get("activate/{code}", ['as' => "pluginBooking.activate.de", 'uses'=>'PluginBookingController@activate', 'middleware' => ['plugin_booking']]);
        Route::get("riassume", ['as' => "pluginBooking.riassume.de", 'uses'=>'PluginBookingController@riassume', 'middleware' => ['plugin_booking']]);
        Route::get("order/{id}", ['as' => "pluginBooking.order.de", 'uses'=>'PluginBookingController@order', 'middleware' => ['plugin_booking']]);
        Route::any("404", ['as' => "pluginBooking.404.de", 'uses' => 'PluginBookingController@not_found', 'middleware' => ['plugin_booking']]);

    });
}

$url_plugin_booking = env("PLUGIN_BOOKING_URL_ES");
if($url_plugin_booking){
    \Route::group(['prefix' => $url_plugin_booking], function () {
        Route::post("/hidden", ['as' => "pluginBookingHidden.es", 'uses' => 'PluginBookingController@hidden', 'middleware' => ['plugin_booking']]);

        Route::any("/", ['as' => "pluginBooking.es", 'uses'=>'PluginBookingController@index', 'middleware' => ['plugin_booking']]);
        Route::post("/choose_type", ['as' => "pluginBooking.choose_type.es", 'uses'=>'PluginBookingController@choose_type', 'middleware' => ['plugin_booking']]);
        Route::post("get_camere", ['as' => "pluginBooking.get_rooms.es", 'uses'=>'PluginBookingController@get_rooms', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi", ['as' => "pluginBooking.get_services.es", 'uses'=>'PluginBookingController@get_services', 'middleware' => ['plugin_booking']]);
        Route::post("set_partecipanti", ['as' => "pluginBooking.set_partecipants.es", 'uses'=>'PluginBookingController@set_partecipants', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi_2", ['as' => "pluginBooking.get_services_2.es", 'uses'=>'PluginBookingController@get_services_2', 'middleware' => ['plugin_booking']]);
        Route::post("get_checkout", ['as' => "pluginBooking.get_checkout.es", 'uses'=>'PluginBookingController@get_checkout', 'middleware' => ['plugin_booking']]);
        Route::post("checkout", ['as' => "pluginBooking.checkout.es", 'uses'=>'PluginBookingController@checkout', 'middleware' => ['plugin_booking']]);
        Route::post("save_order", ['as' => "pluginBooking.save_order.es", 'uses'=>'PluginBookingController@save_order', 'middleware' => ['plugin_booking']]);
        Route::post("save_documents", ['as' => "pluginBooking.save_documents.es", 'uses'=>'PluginBookingController@save_documents', 'middleware' => ['plugin_booking']]);

        Route::get("register", ['as' => "pluginBooking.register.es", 'uses'=>'PluginBookingController@register', 'middleware' => ['plugin_booking']]);
        Route::get("activate/{code}", ['as' => "pluginBooking.activate.es", 'uses'=>'PluginBookingController@activate', 'middleware' => ['plugin_booking']]);
        Route::get("riassume", ['as' => "pluginBooking.riassume.es", 'uses'=>'PluginBookingController@riassume', 'middleware' => ['plugin_booking']]);
        Route::get("order/{id}", ['as' => "pluginBooking.order.es", 'uses'=>'PluginBookingController@order', 'middleware' => ['plugin_booking']]);
        Route::any("404", ['as' => "pluginBooking.404.es", 'uses' => 'PluginBookingController@not_found', 'middleware' => ['plugin_booking']]);

    });
}

$url_plugin_booking = env("PLUGIN_BOOKING_URL_FR");
if($url_plugin_booking){
    \Route::group(['prefix' => $url_plugin_booking], function () {
        Route::post("/hidden", ['as' => "pluginBookingHidden.fr", 'uses' => 'PluginBookingController@hidden', 'middleware' => ['plugin_booking']]);

        Route::any("/", ['as' => "pluginBooking.fr", 'uses'=>'PluginBookingController@index', 'middleware' => ['plugin_booking']]);
        Route::post("/choose_type", ['as' => "pluginBooking.choose_type.fr", 'uses'=>'PluginBookingController@choose_type', 'middleware' => ['plugin_booking']]);
        Route::post("get_camere", ['as' => "pluginBooking.get_rooms.fr", 'uses'=>'PluginBookingController@get_rooms', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi", ['as' => "pluginBooking.get_services.fr", 'uses'=>'PluginBookingController@get_services', 'middleware' => ['plugin_booking']]);
        Route::post("set_partecipanti", ['as' => "pluginBooking.set_partecipants.fr", 'uses'=>'PluginBookingController@set_partecipants', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi_2", ['as' => "pluginBooking.get_services_2.fr", 'uses'=>'PluginBookingController@get_services_2', 'middleware' => ['plugin_booking']]);
        Route::post("get_checkout", ['as' => "pluginBooking.get_checkout.fr", 'uses'=>'PluginBookingController@get_checkout', 'middleware' => ['plugin_booking']]);
        Route::post("checkout", ['as' => "pluginBooking.checkout.fr", 'uses'=>'PluginBookingController@checkout', 'middleware' => ['plugin_booking']]);
        Route::post("save_order", ['as' => "pluginBooking.save_order.fr", 'uses'=>'PluginBookingController@save_order', 'middleware' => ['plugin_booking']]);
        Route::post("save_documents", ['as' => "pluginBooking.save_documents.fr", 'uses'=>'PluginBookingController@save_documents', 'middleware' => ['plugin_booking']]);

        Route::get("register", ['as' => "pluginBooking.register.fr", 'uses'=>'PluginBookingController@register', 'middleware' => ['plugin_booking']]);
        Route::get("activate/{code}", ['as' => "pluginBooking.activate.fr", 'uses'=>'PluginBookingController@activate', 'middleware' => ['plugin_booking']]);
        Route::get("riassume", ['as' => "pluginBooking.riassume.fr", 'uses'=>'PluginBookingController@riassume', 'middleware' => ['plugin_booking']]);
        Route::get("order/{id}", ['as' => "pluginBooking.order.fr", 'uses'=>'PluginBookingController@order', 'middleware' => ['plugin_booking']]);
        Route::any("404", ['as' => "pluginBooking.404.fr", 'uses' => 'PluginBookingController@not_found', 'middleware' => ['plugin_booking']]);

    });
}

$url_plugin_booking = env("PLUGIN_BOOKING_URL_DE");
if($url_plugin_booking){
    \Route::group(['prefix' => $url_plugin_booking], function () {
        Route::post("/hidden", ['as' => "pluginBookingHidden.de", 'uses' => 'PluginBookingController@hidden', 'middleware' => ['plugin_booking']]);

        Route::any("/", ['as' => "pluginBooking.de", 'uses'=>'PluginBookingController@index', 'middleware' => ['plugin_booking']]);
        Route::post("/choose_type", ['as' => "pluginBooking.choose_type.de", 'uses'=>'PluginBookingController@choose_type', 'middleware' => ['plugin_booking']]);
        Route::post("get_camere", ['as' => "pluginBooking.get_rooms.de", 'uses'=>'PluginBookingController@get_rooms', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi", ['as' => "pluginBooking.get_services.de", 'uses'=>'PluginBookingController@get_services', 'middleware' => ['plugin_booking']]);
        Route::post("set_partecipanti", ['as' => "pluginBooking.set_partecipants.de", 'uses'=>'PluginBookingController@set_partecipants', 'middleware' => ['plugin_booking']]);
        Route::post("get_servizi_2", ['as' => "pluginBooking.get_services_2.de", 'uses'=>'PluginBookingController@get_services_2', 'middleware' => ['plugin_booking']]);
        Route::post("get_checkout", ['as' => "pluginBooking.get_checkout.de", 'uses'=>'PluginBookingController@get_checkout', 'middleware' => ['plugin_booking']]);
        Route::post("checkout", ['as' => "pluginBooking.checkout.de", 'uses'=>'PluginBookingController@checkout', 'middleware' => ['plugin_booking']]);
        Route::post("save_order", ['as' => "pluginBooking.save_order.de", 'uses'=>'PluginBookingController@save_order', 'middleware' => ['plugin_booking']]);
        Route::post("save_documents", ['as' => "pluginBooking.save_documents.de", 'uses'=>'PluginBookingController@save_documents', 'middleware' => ['plugin_booking']]);

        Route::get("register", ['as' => "pluginBooking.register.de", 'uses'=>'PluginBookingController@register', 'middleware' => ['plugin_booking']]);
        Route::get("activate/{code}", ['as' => "pluginBooking.activate.de", 'uses'=>'PluginBookingController@activate', 'middleware' => ['plugin_booking']]);
        Route::get("riassume", ['as' => "pluginBooking.riassume.de", 'uses'=>'PluginBookingController@riassume', 'middleware' => ['plugin_booking']]);
        Route::get("order/{id}", ['as' => "pluginBooking.order.de", 'uses'=>'PluginBookingController@order', 'middleware' => ['plugin_booking']]);
        Route::any("404", ['as' => "pluginBooking.404.de", 'uses' => 'PluginBookingController@not_found', 'middleware' => ['plugin_booking']]);

    });
}

// PLUGIN PRODUCT V1 E V2

$url_plugin_product = env("PLUGIN_PRODUCTS_URL_IT");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.it", 'uses' => 'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.it", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.it", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.it", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.it", 'uses' => 'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as' => "pluginProducts.contact_form.send.it", 'uses' => 'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.it", 'uses' => 'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.it", 'uses' => 'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.it", 'uses' => 'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.it", 'uses' => 'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.it", 'uses' => 'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);
}

if((env("PROJECT_NAME") == "Manega") && strpos( \URL::current(),"luxury")){
    $url_plugin_product = "luxury";
    Route::get("$url_plugin_product", ['as' => "pluginProducts.it", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.it", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.it", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.it", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.it", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.it", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.it", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.it", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.it", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.it", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.it", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);

    $url_plugin_product = "luxury-en";
    Route::get("$url_plugin_product", ['as' => "pluginProducts.en", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.en", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.en", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.en", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.en", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.en", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.en", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.en", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.en", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.it", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.en", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);
}


$url_plugin_product = env("PLUGIN_PRODUCTS_URL_EN");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.en", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.en", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.en", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.en", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.en", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.en", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.en", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.en", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.en", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.en", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.en", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);

}

$url_plugin_product = env("PLUGIN_PRODUCTS_URL_FR");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.fr", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.fr", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.fr", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.fr", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.fr", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.fr", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.fr", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.fr", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.fr", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.fr", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.fr", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);
}

$url_plugin_product = env("PLUGIN_PRODUCTS_URL_ES");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.es", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.es", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.es", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.es", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.es", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.es", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.es", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.es", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.es", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.es", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.es", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);
}

$url_plugin_product = env("PLUGIN_PRODUCTS_URL_DE");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.de", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.de", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.de", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.de", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.de", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.de", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.de", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.de", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.de", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.de", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.de", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);
}

$url_plugin_product = env("PLUGIN_PRODUCTS_URL_RO");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.ro", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.ro", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.ro", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.ro", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.ro", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.ro", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.ro", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.ro", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.ro", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.ro", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.ro", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);
}

$url_plugin_product = env("PLUGIN_PRODUCTS_URL_SRB");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.srb", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.srb", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.srb", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.srb", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.srb", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.srb", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.srb", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.srb", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.srb", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.srb", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.srb", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);

}

$url_plugin_product = env("PLUGIN_PRODUCTS_URL_RU");
if($url_plugin_product) {
    Route::get("$url_plugin_product", ['as' => "pluginProducts.ru", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/404", ['as' => "pluginProducts.404.ru", 'uses' => 'PluginProductsController@not_found', 'middleware' => ['plugin_products']]);
    Route::any("$url_plugin_product/search", ['as' => "pluginProducts.search.ru", 'uses' => 'PluginProductsController@search', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/search_results", ['as' => "pluginProducts.search_results.ru", 'uses' => 'PluginProductsController@search_results', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/productPdf/{id}", ['as' => "pluginProducts.pdf.ru", 'uses'=>'PluginProductsController@createPdf', 'middleware' => ['plugin_products']]);
    Route::post("$url_plugin_product/contact_form/send", ['as'=> "pluginProducts.contact_form.send.ru", 'uses'=>'PluginProductsController@contact_form_send', 'middleware' => ['plugin_products', ProtectAgainstSpam::class]]);
    Route::get("$url_plugin_product/tag/{slug}", ['as' => "pluginProductsTags.ru", 'uses'=>'PluginProductsController@pluginProductsTags', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/brand/{slug}", ['as' => "pluginProductsBrands.ru", 'uses'=>'PluginProductsController@pluginProductsBrands', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/choose/{slug}/{id}", ['as' => "pluginProducts.choose.ru", 'uses'=>'PluginProductsController@chooseDetail', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{slug?}", ['as' => "pluginProducts.ru", 'uses'=>'PluginProductsController@pluginProducts', 'middleware' => ['plugin_products']]);
    Route::get("$url_plugin_product/{category}/{slug}", ['as' => "pluginProducts.detail.ru", 'uses'=>'PluginProductsController@pluginProductsDetail', 'middleware' => ['plugin_products']]);

}


// aggiungere qui altre lingue future...


// Fine lingue aggiuntive

// PLUGIN FORM
Route::post("blockPluginForm/contact_form/send", ['as'=> "blockPluginForm.contact_form.send", 'uses'=>'PluginFormsController@contact_form_send'])->middleware(ProtectAgainstSpam::class);

//INDEX SITO
Route::get('/{slug}', ['as' => 'index.page', 'uses'=>'IndexController@index']);

