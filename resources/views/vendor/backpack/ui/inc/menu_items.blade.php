<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
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
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="hgi hgi-stroke hgi-image-add-02 nav-icon"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
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
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon hgi hgi-stroke hgi-image-add-02"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
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
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i> {{ $aP->label }}</a>
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
                                            <span class="badge badge-info" style="float:right;margin-top:3px;margin-right:-2px">{{ $count_not_read }}</span>
                                        @endif
                                        </span>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('pluginProducts.import_export') }}"><i class="nav-icon las la-exchange-alt"></i> Import/Export</a></li>
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
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i> ShopFormula</a>
                        <ul class="nav-dropdown-items">
                                <?php
                                $shopSetting = \App\Models\ShopSettings::first();
                                $count_not_read = \App\Models\Order::where("status_id", $shopSetting->status_default_order)->count();
                                ?>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopOrders') }}">
                                    <i class="nav-icon las la-shopping-bag"></i> <span>Ordini
                                    @if($count_not_read > 0)
                                            <span class="badge badge-info" style="float:right;margin-top:3px;margin-right:-2px">{{ $count_not_read }}</span>
                                        @endif
                                    </span>
                                </a>
                            </li>
                                <?php
                                $count_not_read = \App\Models\PluginProductsRequests::where("is_read", 0)->whereNotNull("order_id")->count();
                                ?>
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('shopOrdersRequests') }}?type=order_id"><i class="nav-icon las la-box-open"></i><span> Richieste
                                    @if($count_not_read > 0)
                                            <span class="badge badge-info" style="float:right;margin-top:3px;margin-right:-2px">{{ $count_not_read }}</span>
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
                                                <span class="badge badge-danger" style="float:right;margin-top:3px;margin-right:-2px">{{ $count_not_read }}</span>
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

                            @if(backpack_user()->roles[0]->id == 1)
                                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('shopAttributes') }}'><i class='nav-icon las la-filter'></i> Attributi</a></li>
                            @endif

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
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-{{ $aP->icon }} nav-icon"></i> {{ $aP->label }}</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginForms') }}"><i class="nav-icon lab la-wpforms"></i> Form</a></li>
                            <?php
                            $count_not_read = \App\Models\PluginFormsRequests::where("is_read", 0)->count();
                            ?>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ backpack_url('pluginFormsRequests') }}"><i class="nav-icon las la-box-open"></i> <span> Richieste
                                @if($count_not_read > 0)
                                        <span class="badge badge-info" style="float:right;margin-top:3px;margin-right:-2px">{{ $count_not_read }}</span>
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
                                    <a class="nav-link" href="{{ backpack_url('pluginOrders') }}?s={{ $s->id }}">- {{ $s->name }}
                                        @if($count > 0)
                                            <span class="badge badge-info" style="background-color:{{ $s->color }};">{{ $count }}</span>
                                        @endif
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
                            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pluginTutorial') }}/view"><i class="nav-icon lab la-wpforms"></i> Anteprima</a></li>
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
                                        <span class="badge badge-info" style="float:right;margin-top:3px;margin-right:-2px">{{ $processed }}</span>
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
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-type') }}'><i class='nav-icon la la-question'></i> Tipologie</a></li>
                        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('plugin-booking-status') }}'><i class='nav-icon la la-question'></i> Stati</a></li>

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
    @endforeach
@endif

<x-backpack::menu-item :title="trans('backpack::crud.file_manager')" icon="nav-icon hgi hgi-stroke hgi-image-add-02" :link="backpack_url('elfinder')" />