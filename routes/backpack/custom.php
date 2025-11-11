<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

$vet = array_merge(
    (array) config('backpack.base.web_middleware', 'web'),
    (array) config('backpack.base.middleware_key', 'admin'),
);


// Attiva le rotte del filemanager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => $vet], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => $vet,
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    Route::crud('page', 'PageCrudController');
    Route::crud('pageBlock', 'PageBlockCrudController');
    Route::crud('websiteSetting', 'WebsiteSettingCrudController');
    Route::crud('userCustom', 'CustomUserCrudController');
    Route::crud('admin-thumb', 'AdminThumbCrudController');

    // rotte blocchi
    Route::crud('blockHtml', 'BlockHtmlCrudController');
    Route::crud('blockImage', 'BlockImageCrudController');
    Route::crud('blockNews', 'BlockNewsCrudController');
    Route::crud('blockSlideshow', 'BlockSlideshowCrudController');
    Route::crud('adminBlock', 'AdminBlockCrudController');
    Route::crud('adminPlugin', 'AdminPluginCrudController');
    Route::crud('adminLanguage', 'AdminLanguageCrudController');
    Route::crud('adminTemplate', 'AdminTemplateCrudController');
    Route::crud('blockDocument', 'BlockDocumentCrudController');
    Route::crud('blockCarousel', 'BlockCarouselCrudController');
    Route::crud('blockSocial', 'BlockSocialCrudController');
    Route::crud('blockContact', 'BlockContactCrudController');
    Route::crud('blockIcon', 'BlockIconCrudController');
    Route::crud('blockHtmlImage', 'BlockHtmlImageCrudController');
    Route::crud('blockImageLink', 'BlockImageLinkCrudController');
    Route::crud('blockTab', 'BlockTabCrudController');
    Route::crud('blockParallax', 'BlockParallaxCrudController');
    Route::crud('blockHightlight', 'BlockHightlightCrudController');
    Route::crud('blockPortfolio', 'BlockPortfolioCrudController');
    Route::crud('userNavigation', 'UserNavigationCrudController');
    Route::crud('blockPortfolio2', 'BlockPortfolio2CrudController');
    Route::crud('blockReference', 'BlockReferenceCrudController');
    Route::crud('blockBanner', 'BlockBannerCrudController');
    Route::crud('blockGallery', 'BlockGalleryCrudController');
    Route::crud('blockHtmlTwocol', 'BlockHtmlTwocolCrudController');
    Route::crud('blockVideobg', 'BlockVideobgCrudController');
    Route::crud('blockFaq', 'BlockFaqCrudController');
    Route::crud('blockHero', 'BlockHeroCrudController');
    Route::crud('blockMetro', 'BlockMetroCrudController');
    Route::crud('blockCollage', 'BlockCollageCrudController');
    Route::crud('blockFlusso', 'BlockFlussoCrudController');
    Route::crud('blockTimeline', 'BlockTimelineCrudController');
    Route::crud('blockStaff', 'BlockStaffCrudController');
    Route::crud('blockContactgmap', 'BlockContactgmapCrudController');
    Route::crud('blockVideotut', 'BlockVideotutCrudController');
    Route::crud('blockLastwork', 'BlockLastworkCrudController');
    Route::crud('blockSeparator', 'BlockSeparatorCrudController');
    Route::crud('blockStore', 'BlockStoreCrudController');
    Route::crud('blockBrand', 'BlockBrandCrudController');
    Route::crud('blockPrice', 'BlockPriceCrudController');
    Route::crud('blockGrid', 'BlockGridCrudController');
    Route::crud('blockScrollbar', 'BlockScrollbarCrudController');
    Route::crud('blockOnePhoto', 'BlockOnePhotoCrudController');
    Route::crud('blockMetrox', 'BlockMetroxCrudController');
    Route::crud('blockListOfLink', 'BlockListOfLinkCrudController');
    Route::crud('blockProgressbar', 'BlockProgressbarCrudController');
    Route::crud('blockScrollingtext', 'BlockScrollingtextCrudController');
    Route::crud('blockCountdown', 'BlockCountdownCrudController');
    Route::crud('blockHtmlbook', 'BlockHtmlbookCrudController');



    // rotte Plugin Tutorial e Contatore
    Route::crud('pluginTutorial', 'PluginTutorialCrudController');
    Route::crud('pluginCounter', 'PluginCounterCrudController');
    Route::crud('blockPluginCounter', 'BlockPluginCounterCrudController');


    // rotte Plugin Inviti
    Route::crud('pluginInvitations', 'PluginInvitationsCrudController');
    Route::crud('pluginInvitationsSettings', 'PluginInvitationsSettingsCrudController');
    Route::crud('pluginInvitationsUsersSettings', 'PluginInvitationsUsersSettingsCrudController');


    // rotte Plugin Prodotti
    Route::crud('pluginProducts', 'PluginProductsCrudController');
    Route::crud('pluginProductsClients', 'PluginProductsClientsCrudController');
    Route::crud('pluginProductsBuyers', 'PluginProductsBuyersCrudController');
    Route::crud('pluginProductsBrands', 'PluginProductsBrandsCrudController');
    Route::crud('pluginProductsCategories', 'PluginProductsCategoriesCrudController');
    Route::crud('pluginProductsSettings', 'PluginProductsSettingsCrudController');
    Route::crud('pluginProductsContacts', 'PluginProductsContactsCrudController');
    Route::crud('pluginProductsRequests', 'PluginProductsRequestsCrudController');
    Route::crud('pluginProductsAttributes', 'PluginProductsAttributesCrudController');
    Route::crud('pluginProductsOptions', 'PluginProductsOptionsCrudController');
    Route::crud('pluginProductsLabels', 'PluginProductsLabelsCrudController');
    Route::crud('pluginProductsAttachments', 'PluginProductsAttachmentsCrudController');
    Route::crud('pluginProductsImages', 'PluginProductsImagesCrudController');

    Route::crud('blockPluginProduct', 'BlockPluginProductCrudController');
    Route::crud('label', 'LabelCrudController');
    Route::crud('pluginForms', 'PluginFormsCrudController');
    Route::crud('pluginFormsRequests', 'PluginFormsRequestsCrudController');
    Route::crud('pluginFormsSettings', 'PluginFormsSettingsCrudController');
    Route::crud('blockPluginForm', 'BlockPluginFormCrudController');

    Route::crud('pluginOrdersStatuses', 'PluginOrdersStatusesCrudController');
    Route::crud('pluginOrdersCategories', 'PluginOrdersCategoriesCrudController');
    Route::crud('pluginOrdersSettings', 'PluginOrdersSettingsCrudController');
    Route::crud('pluginOrdersClients', 'PluginOrdersClientsCrudController');
    Route::crud('pluginOrdersProducts', 'PluginOrdersProductsCrudController');
    Route::crud('pluginOrders', 'PluginOrdersCrudController');
    Route::crud('blockPluginProductSearch', 'BlockPluginProductSearchCrudController');

    Route::crud('shopAddresses', 'ShopAddressesCrudController');
    Route::crud('shopCompanies', 'ShopCompaniesCrudController');
    Route::crud('shopTaxes', 'ShopTaxesCrudController');
    Route::crud('shopPayments', 'ShopPaymentsCrudController');
    Route::crud('shopOrdersStatus', 'ShopOrdersStatusCrudController');
    Route::crud('shopCountries', 'ShopCountriesCrudController');
    Route::crud('shopAreas', 'ShopAreasCrudController');
    Route::crud('shopShippings', 'ShopShippingsCrudController');
    Route::crud('shopOrders', 'ShopOrdersCrudController');
    Route::crud('shopSettings', 'ShopSettingsCrudController');
    Route::crud('shopCartRules', 'ShopCartRulesCrudController');
    Route::crud('shopPromotions', 'ShopPromotionsCrudController');
    Route::crud('shopGroupSpecificPrices', 'ShopGroupSpecificPricesCrudController');
    Route::crud('shopOrdersRequests', 'ShopOrdersRequestsCrudController');
    Route::crud('shopAttributes', 'ShopAttributesCrudController');
    Route::crud('shopAttributesOptions', 'ShopAttributesOptionsCrudController');
    Route::crud('shopProductsVariants', 'ShopProductsVariantsCrudController');

    //Route::crud('block-html-twocol', 'BlockHtmlTwocolCrudController');
    Route::crud('pluginProductsImagesSize', 'PluginProductsImagesSizeCrudController');


    Route::crud('blockPluginProductLast', 'BlockPluginProductLastCrudController');
    Route::crud('shop-extra', 'ShopExtraCrudController');

    // rotte Plugin Booking
    Route::crud('plugin-booking-room', 'PluginBookingRoomCrudController');
    Route::crud('plugin-booking-room-images', 'PluginBookingRoomImagesCrudController');
    Route::crud('plugin-booking-room-services', 'PluginBookingRoomServicesCrudController');
    Route::crud('plugin-booking-services', 'PluginBookingServicesCrudController');
    Route::crud('plugin-booking-settings', 'PluginBookingSettingsCrudController');
    Route::crud('plugin-booking-payments', 'PluginBookingPaymentsCrudController');
    Route::crud('plugin-booking-reservation', 'PluginBookingReservationCrudController');
    Route::crud('pluginBookingClients', 'PluginBookingClientsCrudController');
    Route::crud('plugin-booking-type', 'PluginBookingTypeCrudController');
    Route::crud('plugin-booking-status', 'PluginBookingStatusCrudController');
    Route::crud('blockPluginBooking', 'BlockPluginBookingCrudController');
    Route::crud('blockPluginBookingSearchType', 'BlockPluginBookingSearchTypeCrudController');

    // rotte Plugin Caccia
    Route::crud('plugin-caccia-hunters', 'PluginCacciaHuntersCrudController');
    Route::crud('plugin-caccia-chiefs', 'PluginCacciaChiefsCrudController');
    Route::crud('plugin-caccia-hunters-chiefs', 'PluginCacciaHuntersChiefsCrudController');
    Route::crud('plugin-caccia-settings', 'PluginCacciaSettingsCrudController');
    Route::crud('plugin-caccia-hunters-points', 'PluginCacciaHuntersPointsCrudController');
    Route::crud('blockPluginCaccia', 'BlockPluginCacciaCrudController');

    // rotte Plugin Orari
    Route::crud('plugin-timetables', 'PluginTimetablesCrudController');
    Route::crud('plugin-timetable-setting', 'PluginTimetableSettingCrudController');
    Route::crud('blockPluginTimetable', 'BlockPluginTimetableCrudController');



    Route::crud('plugin-booking-labels', 'PluginBookingLabelsCrudController');
    Route::crud('city', 'CityCrudController');
    Route::crud('plugin-parking-reservation', 'PluginParkingReservationCrudController');
    Route::crud('plugin-parking-price', 'PluginParkingPriceCrudController');
    Route::crud('plugin-parking-setting', 'PluginParkingSettingCrudController');
    Route::crud('blockPluginParking', 'BlockPluginParkingCrudController');
    Route::crud('plugin-parking-price-rule', 'PluginParkingPriceRuleCrudController');
    Route::crud('plugin-parking-label', 'PluginParkingLabelCrudController');


    Route::crud('plugin-interventions', 'PluginInterventionsCrudController');
    Route::crud('plugin-interventions-clients', 'PluginInterventionsClientsCrudController');
    Route::crud('plugin-interventions-drivers', 'PluginInterventionsDriversCrudController');
    Route::crud('plugin-interventions-vehicles', 'PluginInterventionsVehiclesCrudController');
    Route::crud('plugin-interventions-laborers', 'PluginInterventionsLaborersCrudController');
    Route::crud('plugin-interventions-status', 'PluginInterventionsStatusCrudController');
    Route::crud('plugin-interventions-setting', 'PluginInterventionsSettingCrudController');

    Route::crud('block-metrox', 'BlockMetroxCrudController');
    Route::crud('block-page', 'BlockPageCrudController');
    Route::crud('user-subscription', 'UserSubscriptionCrudController');
    Route::crud('plugin-interventions-note', 'PluginInterventionsNoteCrudController');
    Route::crud('plugin-labels', 'PluginLabelsCrudController');
    Route::crud('plugin-labels-settings', 'PluginLabelsSettingsCrudController');


    Route::get('filemanager', function () {
        return view('vendor/backpack/custom/filemanager');
    })->name('backpack.filemanager');
    Route::crud('plugin-product-import', 'PluginProductImportCrudController');

}); // this should be the absolute last line of this file

