<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@php
    $adminPanelFontUrl = null;
    $adminPanelFontFamily = null;
    $websiteSetting = \App\Models\WebsiteSetting::select('admin_panel_font', 'admin_panel_template')->first();
    $isModernAdminTemplate = \App\Models\WebsiteSetting::isAdminModernTemplate();
    $isModernAdminTemplate02 = \App\Models\WebsiteSetting::isAdminModern02Template();

    if ($websiteSetting && !empty($websiteSetting->admin_panel_font)) {
        $candidateFontUrl = trim($websiteSetting->admin_panel_font);
        $parsedHost = parse_url($candidateFontUrl, PHP_URL_HOST);
        $parsedScheme = parse_url($candidateFontUrl, PHP_URL_SCHEME);

        if (
            filter_var($candidateFontUrl, FILTER_VALIDATE_URL) &&
            in_array($parsedScheme, ['http', 'https'], true) &&
            in_array($parsedHost, ['fonts.googleapis.com', 'fonts.googleapis.com.'], true)
        ) {
            $adminPanelFontUrl = $candidateFontUrl;
            parse_str((string) parse_url($adminPanelFontUrl, PHP_URL_QUERY), $fontQueryString);

            if (!empty($fontQueryString['family'])) {
                $familyParts = explode('|', (string) $fontQueryString['family']);
                $firstFamily = explode(':', (string) $familyParts[0])[0] ?? '';
                $adminPanelFontFamily = trim(str_replace('+', ' ', $firstFamily));
            }
        }
    }
@endphp

@if($adminPanelFontUrl && $adminPanelFontFamily)
    <style>
        @import url('{{ $adminPanelFontUrl }}');

        body,
        .app-body,
        .app-header,
        .main,
        .page-title,
        .card,
        .btn,
        .table,
        .form-control,
        .custom-select,
        .nav-link,
        .dropdown-menu,
        .breadcrumb,
        h1, h2, h3, h4, h5, h6,
        p,
        span,
        label,
        small,
        td,
        th {
            font-family: '{{ str_replace("'", "\\'", $adminPanelFontFamily) }}', sans-serif;
        }
    </style>
@endif

@if($isModernAdminTemplate)
<style>
    .sidebar,
    .sidebar-nav {
        background: linear-gradient(160deg, var(--admin-leftbar-bg, #1B2A4E), var(--admin-leftbar-bg-light, #2b477f)) !important;
    }

    .sidebar .nav,
    .sidebar .sidebar-nav,
    .sidebar-nav {
        padding: .55rem .5rem 1rem !important;
        gap: .3rem;
        width: 100% !important;
        box-sizing: border-box;
    }

    .sidebar .nav-link {
        border-radius: 12px !important;
        padding: .62rem .78rem !important;
        font-weight: 600 !important;
        letter-spacing: .01em;
        color: var(--admin-leftbar-bg, #1B2A4E) !important;
        background: #ffffff !important;
        transition: background-color .18s ease, color .18s ease, transform .18s ease;
    }

    .sidebar .nav-item {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .sidebar .nav-link .nav-icon {
        color: var(--admin-leftbar-bg, #1B2A4E) !important;
        transition: color .18s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: #dfe3ea !important;
        color: var(--admin-leftbar-bg, #1B2A4E) !important;
        transform: translateX(1px);
    }

    .sidebar .nav-link:hover .nav-icon,
    .sidebar .nav-link.active .nav-icon {
        color: var(--admin-leftbar-bg, #1B2A4E) !important;
    }

    .sidebar .nav-dropdown.open > .nav-link {
        background: transparent !important;
        color: var(--admin-leftbar-bg, #1B2A4E) !important;
    }

    .sidebar .nav-dropdown.open {
        border-radius: 12px;
        overflow: hidden;
        background: #dfe3ea !important;
    }

    .sidebar .nav-dropdown-items {
        margin-top: .2rem;
        padding-left: .35rem;
        border-left: 1px solid rgba(255, 255, 255, .3);
    }

    .sidebar .nav-dropdown.open > .nav-dropdown-items {
        margin-top: 0;
        padding: .35rem .35rem .4rem;
        border-left: 0;
        border-radius: 0;
        background: transparent;
    }

    .sidebar .nav-dropdown.open > .nav-dropdown-items .nav-link {
        border-radius: 10px !important;
    }

    .sidebar .nav-dropdown-items .nav-link {
        font-weight: 500 !important;
        color: var(--admin-leftbar-bg, #1B2A4E) !important;
    }

    .sidebar .nav-dropdown-toggle::before {
        right: .78rem !important;
    }

    .sidebar .badge {
        border-radius: 999px;
        padding: .18rem .46rem;
        font-size: .68rem;
        font-weight: 700;
    }

    @if($isModernAdminTemplate02)
    .sidebar,
    .sidebar-nav {
        background:
            radial-gradient(480px 320px at 20% -15%, rgba(255, 255, 255, .16), transparent 68%),
            linear-gradient(180deg, var(--admin-leftbar-bg-light, #2b477f) 0%, var(--admin-leftbar-bg, #1B2A4E) 100%) !important;
        border-right: 1px solid rgba(255, 255, 255, .22);
    }

    .sidebar .nav-link {
        background: transparent !important;
        color: rgba(238, 244, 255, .95) !important;
        border: 1px solid transparent;
        border-radius: 0 !important;
        position: relative;
        box-shadow: none !important;
    }

    .sidebar .nav-link .nav-icon {
        color: rgba(238, 244, 255, .82) !important;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, .18) !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, .26);
        box-shadow: none !important;
    }

    .sidebar .nav-link:hover .nav-icon,
    .sidebar .nav-link.active .nav-icon {
        color: #ffffff !important;
    }

    .sidebar .nav-dropdown.open {
        background: rgba(255, 255, 255, .12) !important;
        border-radius: 0;
    }

    .sidebar .nav-link::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: rgba(255, 255, 255, .95);
        opacity: 0;
        transition: opacity .18s ease;
    }

    .sidebar .nav-link:hover::before,
    .sidebar .nav-link.active::before,
    .sidebar .nav-dropdown.open > .nav-link::before {
        opacity: 1;
    }

    .sidebar .nav-dropdown.open > .nav-link,
    .sidebar .nav-dropdown-items .nav-link {
        border-radius: 0 !important;
    }

    .sidebar .nav-dropdown-toggle::before {
        display: none !important;
    }

    .sidebar .nav-dropdown-toggle::after {
        content: "▾";
        position: absolute;
        right: .78rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .78rem;
        line-height: 1;
        color: rgba(238, 244, 255, .9);
        opacity: .95;
    }
    @endif
</style>
@endif

@if(backpack_user()->roles[0]->id < 5)
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="hgi hgi-stroke hgi-home-09 nav-icon"></i> Bacheca</a></li>
@endif

@if(backpack_user()->roles[0]->id == 1)
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class="hgi hgi-stroke hgi-file-01 nav-icon"></i> Pagine</a></li>
@else
    @if(env('NASCONDI_FRONTEND') == 0)
        @if(backpack_user()->roles[0]->id < 5)
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='hgi hgi-stroke hgi-file-01 nav-icon'></i> Pagine</a></li>
        @endif
    @endif
@endif


@if(backpack_user()->roles[0]->id == 1)

    @if(env("APP_URL") == "https://dev.cmsformula.it")
        <li class="nav-item">
            <a class="nav-link" href="{{ route('backpack.filemanager') }}">
                <i class="la la-folder-open nav-icon"></i> <span>File Manager New</span>
            </a>
        </li>
    @else
        <x-backpack::menu-item :title="trans('backpack::crud.file_manager')" icon="nav-icon hgi hgi-stroke hgi-image-add-02" :link="backpack_url('elfinder')" />
    @endif
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="hgi hgi-stroke hgi-user-square nav-icon"></i> Accounts</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('userCustom') }}"><i class="hgi hgi-stroke hgi-user-multiple-02 nav-icon"></i> <span>Utenti</span></a></li>
        </ul>
    </li>

    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="hgi hgi-stroke hgi-settings-05 nav-icon"></i> Impostazioni</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('websiteSetting') }}/1/edit"><i class="nav-icon la la-tools"></i> Sito web</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('adminBlock') }}"><i class="nav-icon la la-file-code"></i> <span>Blocchi</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('adminPlugin') }}"><i class="nav-icon las la-plug"></i> <span>Plugins</span></a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('adminTemplate') }}'><i class="nav-icon las la-brush"></i> Template</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('admin-thumb') }}'><i class='nav-icon las la-icons'></i> Thumbs</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('adminLanguage') }}"><i class="nav-icon la la-language"></i> Lingue</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('userNavigation') }}'><i class='nav-icon las la-user-lock'></i> Navigazione</a></li>
            <li class="nav-item"><a class="nav-link" href="/sitemap.xml" target="_blank"><i class="nav-icon las la-sitemap"></i> <span>Sitemap</span></a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('label') }}'><i class="nav-icon las la-spell-check"></i> Etichette</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('block-page') }}'><i class='nav-icon la la-question'></i> Storico Blocchi</a></li>
        </ul>
    </li>

@endif

@if(backpack_user()->roles[0]->id == 2)
    @if(env('NASCONDI_FRONTEND') == 0)
        <x-backpack::menu-item :title="trans('backpack::crud.file_manager')" icon="nav-icon hgi hgi-stroke hgi-image-add-02" :link="backpack_url('elfinder')" />
    @endif

    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon hgi hgi-stroke hgi-user-square"></i> Accounts</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('userCustom') }}"><i class="nav-icon hgi hgi-stroke hgi-user-multiple-02"></i> <span>Utenti</span></a></li>
        </ul>
    </li>
    @if(env('NASCONDI_FRONTEND') == 0)
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="hgi hgi-stroke hgi-settings-05 nav-icon"></i> Impostazioni</a>
            <ul class="nav-dropdown-items">
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('websiteSetting') }}/1/edit"><i class="nav-icon la la-tools"></i> <span>Sito web</span></a></li>
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('adminTemplate') }}'><i class="nav-icon las la-brush"></i> Template</a></li>
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('userNavigation') }}'><i class='nav-icon las la-user-lock'></i> Navigazione</a></li>
                <li class="nav-item"><a class="nav-link" href="/sitemap.xml" target="_blank"><i class="nav-icon las la-sitemap"></i> <span>Sitemap</span></a></li>
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('label') }}'><i class="nav-icon las la-spell-check"></i> Etichette</a></li>
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('admin-thumb') }}'><i class='nav-icon las la-icons'></i> Thumbs</a></li>
            </ul>
        </li>
    @endif
@endif


<?php
$adminPlugin = \App\Models\AdminPlugin::where("is_active", 1)->get();

$adminPluginProduct = \App\Models\AdminPlugin::where("name", "pluginProducts")->where("is_active", 1)->where("version", 3)->first();
$shopFormulaMenuOpen = request()->is('admin/shopOrders*')
    || request()->is('admin/shopOrdersRequests*')
    || request()->is('admin/pluginProductsClients*')
    || request()->is('admin/user-subscription*')
    || request()->is('admin/pluginProductsBuyers*')
    || request()->is('admin/shopPayments*')
    || request()->is('admin/shopShippings*')
    || request()->is('admin/shopOrdersStatus*')
    || request()->is('admin/shopCountries*')
    || request()->is('admin/shopAreas*')
    || request()->is('admin/shopTaxes*')
    || request()->is('admin/shopCartRules*')
    || request()->is('admin/shopPromotions*')
    || request()->is('admin/shopAttributes*')
    || request()->is('admin/shopAttributesOptions*')
    || request()->is('admin/shopSettings*')
    || request()->is('admin/shop-extra*')
    || request()->is('admin/pluginInvitations*')
    || request()->is('admin/pluginInvitationsSettings*')
    || request()->is('admin/pluginInvitationsUsersSettings*');
$catalogoMenuOpen = request()->is('admin/pluginProducts*')
    || request()->is('admin/pluginProductsBrands*')
    || request()->is('admin/pluginProductsCategories*')
    || request()->is('admin/pluginProductsAttributes*')
    || request()->is('admin/pluginProductsContacts*')
    || request()->is('admin/pluginProductsRequests*')
    || request()->is('admin/pluginProductsLabels*')
    || request()->is('admin/pluginProductsSettings*')
    || request()->is('admin/plugin-product-import*');
?>

@if($adminPlugin)
    @foreach($adminPlugin as $aP)
            <?php
            if(backpack_user()->roles[0]->id == 4){
                continue;
            }
            ?>

        @if($aP->name == "pluginProducts")
                <?php
                $adminPluginInvitation = \App\Models\AdminPlugin::where("name", "pluginInvitations")->where("is_active", 1)->first();
                ?>

            @if(backpack_user()->roles[0]->id < 5)
                <li class="nav-item nav-dropdown{{ $catalogoMenuOpen ? ' open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-box-open"></i> {{ $aP->label }}</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProducts') }}"><i class="nav-icon las la-shopping-bag"></i> {{ env('PLUGIN_PRODUCTS_LABEL_ADMIN', 'Prodotti') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsBrands') }}"><i class="nav-icon las la-bookmark"></i> Brand</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsCategories') }}"><i class="nav-icon las la-tags"></i> Categorie</a></li>
                        @if($aP->version >= 1)
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginProductsAttributes') }}'><i class="nav-icon las la-filter"></i> Proprietà</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsContacts') }}/1/edit"><i class="nav-icon lab la-wpforms"></i> Form contatti</a></li>
                                <?php
                                $count_not_read = \App\Models\PluginProductsRequests::where("is_read", 0)->whereNotNull("product_id")->count();
                                ?>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsRequests') }}?type=product_id"><i class="nav-icon las la-box-open"></i><span> Richieste
                                        @if($count_not_read > 0)
                                            <span class="badge badge-info">{{ $count_not_read }}</span>
                                        @endif
                                        </span>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('pluginProducts.import_export') }}"><i class="nav-icon las la-exchange-alt"></i> Import/Export</a></li>

                            @if(env('IMPORT_SPECIAL') == 1)
                               <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-product-import') }}"><i class="nav-icon las la-exchange-alt"></i> Import Config.</a></li>
                            @endif

                        @endif

                        @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginProductsLabels') }}'><i class="nav-icon las la-spell-check"></i> Etichette Lingua</a></li>
                        @endif

                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsSettings') }}/1/edit"><i class="nav-icon las la-toolbox"></i> Impostazioni</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopSettings') }}/1/edit"><i class="nav-icon las la-toolbox"></i> Avanzate </a></li>

                    </ul>
                </li>
            @endif
            @if($aP->version == 3)
                @if(backpack_user()->roles[0]->id < 5)
                    <li class="nav-item nav-dropdown{{ $shopFormulaMenuOpen ? ' open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-cash-register"></i> ShopFormula</a>
                        <ul class="nav-dropdown-items">
                                <?php
                                $shopSetting = \App\Models\ShopSettings::first();
                                $count_not_read = \App\Models\Order::where("status_id", $shopSetting->status_default_order)->count();
                                ?>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopOrders') }}">
                                    <i class="nav-icon las la-shopping-bag"></i> <span>Ordini
                                    @if($count_not_read > 0)
                                            <span class="badge badge-info">{{ $count_not_read }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                                <?php
                                $count_not_read = \App\Models\PluginProductsRequests::where("is_read", 0)->whereNotNull("order_id")->count();
                                ?>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopOrdersRequests') }}?type=order_id"><i class="nav-icon las la-box-open"></i><span> Richieste
                                    @if($count_not_read > 0)
                                            <span class="badge badge-info">{{ $count_not_read }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsClients') }}"><i class="nav-icon las la-user-tie"></i> Clienti</a></li>

                            @if($shopSetting->is_subscriptions)
                                    <?php
                                    $count_not_read = \App\Models\UserSubscription::whereNull("end")->count();
                                    ?>
                                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user-subscription') }}"><i class="nav-icon las la-user-tie"></i>
                                        <span>
                                             Abbonamenti
                                             @if($count_not_read > 0)
                                                <span class="badge badge-danger">{{ $count_not_read }}</span>
                                            @endif
                                         </span>
                                    </a>
                                </li>
                            @endif

                                <?php
                                $role = \Spatie\Permission\Models\Role::where("name", "Buyer")->first();
                                ?>
                            @if($role)
                                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsBuyers') }}"><i class="nav-icon las la-user-tie"></i> Buyers</a></li>
                            @endif
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopPayments') }}"><i class="nav-icon las la-money-bill"></i> Pagamenti </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopShippings') }}"><i class="nav-icon las la-truck"></i> Spedizioni </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopOrdersStatus') }}"><i class="nav-icon las la-clipboard-list"></i> Stati d'ordine </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopCountries') }}"><i class="nav-icon las la-globe-europe"></i> Nazioni </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopAreas') }}"><i class="nav-icon las la-map-marker"></i> Zone </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopTaxes') }}"><i class="nav-icon las la-file-invoice-dollar"></i> Tasse </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopCartRules') }}"><i class="nav-icon las la-tag"></i> Codici sconto </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopPromotions') }}"><i class="nav-icon las la-bullhorn"></i> Promozioni </a></li>
                            <!--<li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopGroupSpecificPrices') }}"><i class="nav-icon las la-users"></i> Prezzi specifici </a></li>-->

                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('shopAttributes') }}'><i class='nav-icon las la-filter'></i> Attributi</a></li>
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('shopAttributesOptions') }}'><i class='nav-icon las la-fill-drip'></i> Opzioni</a></li>

                            @if(backpack_user()->roles[0]->id <= 2)
                                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopSettings') }}/1/edit"><i class="nav-icon las la-toolbox"></i> Impostazioni </a></li>
                                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('shop-extra') }}'><i class='nav-icon la la-question'></i> Extra</a></li>

                                @if($adminPluginInvitation)
                                        <?php
                                        $label = "Inviti";
                                        $label_setting = "Setting inviti";
                                        ?>
                                    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginInvitations') }}'><i class='nav-icon las la-paper-plane'></i> {{ $label }}</a></li>
                                    @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginInvitationsSettings') }}/1/edit'><i class='nav-icon la la-cog'></i> {{ $label_setting }}</a></li>
                                    @else
                                            <?php
                                            $sett = \App\Models\PluginInvitationsUsersSettings::where("user_id", backpack_user()->id)->first();
                                            if(!$sett){
                                                $urlsett = "/create";
                                            }else{
                                                $urlsett = "/$sett->id/edit";
                                            }
                                            ?>
                                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginInvitationsUsersSettings') }}{{ $urlsett }}'><i class='nav-icon la la-cog'></i> {{ $label_setting }}</a></li>
                                    @endif
                                @endif
                            @endif
                        </ul>
                    </li>
                @endif
            @endif

            @if(backpack_user()->roles[0]->id == 7)
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopOrders') }}"><i class="nav-icon las la-shopping-bag"></i> <span>Ordini </span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginProductsClients') }}"><i class="nav-icon las la-user-tie"></i> Clienti</a></li>
            @endif

        @endif

        @if($aP->name == "pluginForms")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon lab la-wpforms"></i> {{ $aP->label }}</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginForms') }}"><i class="nav-icon lab la-wpforms"></i> Form</a></li>
                            <?php
                            $count_not_read = \App\Models\PluginFormsRequests::where("is_read", 0)->count();
                            ?>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ backpack_url('pluginFormsRequests') }}"><i class="nav-icon las la-box-open"></i> <span> Richieste
                                @if($count_not_read > 0)
                                        <span class="badge badge-info">{{ $count_not_read }}</span>
                                    @endif
                                </span>
                            </a>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginFormsSettings') }}/1/edit"><i class="nav-icon las la-toolbox"></i> <span>Impostazioni</span></a></li>
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginOrders")
            @if(backpack_user()->roles[0]->id <= 3)
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i> {{ $aP->label }}</a>
                    <ul class="nav-dropdown-items">
                            <?php
                            $status = \App\Models\PluginOrdersStatuses::get();
                            $now = \Carbon\Carbon::now()->toDateString();
                            ?>
                        @if($status)
                            @foreach($status as $s)
                                <?php
                                $count = \App\Models\PluginOrders::where("plugin_order_status_id", $s->id)->where("date_delivery", ">=", $now)->count();
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ backpack_url('pluginOrders') }}?s={{ $s->id }}">
                                        <i class="nav-icon las la-shopping-bag"></i> <span>{{ $s->name }}
                                            @if($count > 0)
                                                <span class="badge badge-info">{{ $count }}</span>
                                            @endif
                                    </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif

                        <li class="nav-item"><a class="nav-link" href="{{ route('PluginOrder.planning') }}"><i class="nav-icon las la-calendar"></i> Calendario</a></li>
                        @if(backpack_user()->roles[0]->id <= 3)
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginOrdersProducts') }}"><i class="nav-icon las la-birthday-cake"></i> Prodotti</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginOrdersClients') }}"><i class="nav-icon las la-user-circle"></i> Clienti</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginOrdersCategories') }}"><i class="nav-icon las la-shopping-bag"></i> Categorie</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginOrdersStatuses') }}"><i class="nav-icon las la-shopping-bag"></i> Status</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginOrdersSettings') }}/1/edit"><i class="nav-icon las la-toolbox"></i> <span>Impostazioni</span></a></li>
                        @endif
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginTutorials")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i> {{ $aP->label }}</a>
                    <ul class="nav-dropdown-items">
                        @if(backpack_user()->roles[0]->id == 1)
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginTutorial') }}"><i class="nav-icon lab la-wpforms"></i> Video</a></li>

                        <!--
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginTutorial') }}/view"><i class="nav-icon lab la-wpforms"></i> Anteprima</a></li> -->
                        @endif
                        @if(backpack_user()->roles[0]->id >= 2)
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginTutorial') }}"><i class="nav-icon lab la-wpforms"></i> Video</a></li>
                        @endif
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginCounters")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginCounter') }}'><i class='nav-icon la la-{{ $aP->icon }}'></i> {{ $aP->label }}</a></li>
            @endif
        @endif

        @if($aP->name == "pluginInvitations" && !$adminPluginProduct)
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2 || backpack_user()->roles[0]->id == 6)
                <li class="nav-item nav-dropdown">
                        <?php
                        if(backpack_user()->country_id == config('config.default_country_user_it')){
                            $title = $aP->label;
                            $label = "Elenco";
                            $label_setting = "Impostazioni";
                        }else{
                            $title = "Invitations";
                            $label = "List";
                            $label_setting = "Setting";
                        }
                        ?>
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i> {{ $title }}</a>
                    <ul class="nav-dropdown-items">
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginInvitations') }}'><i class='nav-icon las la-paper-plane'></i> {{ $label }}</a></li>
                        @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginInvitationsSettings') }}/1/edit'><i class='nav-icon la la-cog'></i> {{ $label_setting }}</a></li>
                        @else
                                <?php
                                $sett = \App\Models\PluginInvitationsUsersSettings::where("user_id", backpack_user()->id)->first();
                                if(!$sett){
                                    $urlsett = "/create";
                                }else{
                                    $urlsett = "/$sett->id/edit";
                                }
                                ?>
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pluginInvitationsUsersSettings') }}{{ $urlsett }}'><i class='nav-icon la la-cog'></i> {{ $label_setting }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginBookings")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i> Booking</a>
                    <ul class="nav-dropdown-items">
                        <li class='nav-item'><a class='nav-link' href='{{ route('pluginBookings.planning') }}'><i class='nav-icon la la-calendar-day'></i> Agenda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginBookingClients') }}"><i class="nav-icon las la-user-tie"></i> Clienti</a></li>

                            <?php
                            $status = \App\Models\PluginBookingStatus::where("is_annullato", 1)->get()->pluck("id", "id")->toArray();
                            $processed = \App\Models\PluginBookingReservation::where("is_processed", 0)
                                ->whereNotIn("plugin_booking_status_id", $status)
                                ->count();
                            ?>
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-reservation') }}'><i class='nav-icon la la-key'></i> <span>Prenotazioni
                                    @if($processed > 0)
                                            <span class="badge badge-info">{{ $processed }}</span>
                                        @endif
                                        </span>
                                </a>
                            </li>

                            <?php
                            $types = \App\Models\PluginBookingType::get();
                            ?>
                        @if($types)
                            @foreach($types as $type)
                                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-room') }}?type={{ $type->id }}'><i class="la la-{{ $type->icon }} nav-icon"></i> {{ $type->name }}</a></li>
                            @endforeach
                        @endif
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-services') }}'><i class='nav-icon la la-glass-martini'></i> Servizi</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-payments') }}'><i class='nav-icon la la-credit-card'></i> Pagamenti</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-settings') }}/1/edit'><i class='nav-icon las la-toolbox'></i> Impostazioni</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-type') }}'><i class='nav-icon la la-list'></i> Tipologie</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-status') }}'><i class='nav-icon la la-tags'></i> Stati</a></li>

                        @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-labels') }}'><i class='nav-icon las la-spell-check'></i> Etichette</a></li>
                        @endif
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginCaccia")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i>Plugin Caccia</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-caccia-hunters') }}"><i class="nav-icon las la-id-card"></i> Cacciatori</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-caccia-chiefs') }}'><i class='nav-icon la la-crow'></i> Capi</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-caccia-hunters-chiefs') }}'><i class='nav-icon la la-hand-point-right'></i> Assegnazioni</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ route('pluginCaccia.graduatoria') }}'><i class='nav-icon la la-poll'></i> Graduatoria</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-caccia-settings') }}/1/edit'><i class='nav-icon la la-toolbox'></i> Impostazioni</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('pluginCaccia.import') }}"><i class="nav-icon las la-exchange-alt"></i> Import</a></li>
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginTimetable")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i>Plugin Orari</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-timetables') }}"><i class="nav-icon las la-id-card"></i> Orari</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-timetable-setting') }}/1/edit'><i class='la la-cog nav-icon'></i> Impostazioni</a></li>
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginParking")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i>Plugin Parking</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ route('pluginParking.monitor') }}"><i class="nav-icon las la-calendar"></i> Entrate/Uscite</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-parking-reservation') }}"><i class="nav-icon las la-id-card"></i> Prenotazioni</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('pluginParking.panoramica') }}"><i class="nav-icon las la-calendar"></i> Panoramica</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-parking-price') }}"><i class="nav-icon las la-euro-sign"></i> Tariffario</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-parking-setting') }}/1/edit'><i class='la la-cog nav-icon'></i> Impostazioni</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-parking-label') }}'><i class='nav-icon las la-spell-check'></i> Etichette</a></li>
                    </ul>
                </li>
            @endif
        @endif

        @if($aP->name == "pluginIntervention")
            @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                <li class="nav-item nav-dropdown open">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i>Plugin Interventi</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ route('pluginInterventions.monitor') }}"><i class="nav-icon las la-calendar"></i> Panoramica</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-interventions') }}"><i class="nav-icon las la-id-card"></i> Interventi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-interventions-clients') }}"><i class="nav-icon las la-users"></i> Clienti</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-interventions-note') }}'><i class='nav-icon la la-list'></i> Note</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-interventions-vehicles') }}"><i class="nav-icon las la-car-side"></i> Mezzi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-interventions-drivers') }}"><i class="nav-icon las la-user-shield"></i> Autisti</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-interventions-laborers') }}"><i class="nav-icon las la-users-cog"></i> Manovali</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-interventions-status') }}"><i class="nav-icon las la-list"></i> Stati</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-interventions-setting') }}/1/edit'><i class='la la-cog nav-icon'></i> Impostazioni</a></li>
                    </ul>
                </li>
            @endif
        @endif

            @if($aP->name == "pluginLabel")
                @if(backpack_user()->roles[0]->id == 1 || backpack_user()->roles[0]->id == 2)
                    <li class="nav-item nav-dropdown open">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i>Plugin Etichette</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('plugin-labels') }}"><i class="nav-icon las la-id-card"></i> Etichette</a></li>
                            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-labels-settings') }}/1/edit'><i class='la la-cog nav-icon'></i> Impostazioni</a></li>
                        </ul>
                    </li>
                @endif
            @endif
    @endforeach
@endif

