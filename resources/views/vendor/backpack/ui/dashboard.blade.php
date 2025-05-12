@extends(backpack_view('blank'))

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">Bacheca

        </span>
    </h3>

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row row-short pt-4">
            <div class="col-xl-8 col-xx" id="column-banner">
                <div class="banner-container">
                    <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v5.4.1 -->
                    <ins data-revive-zoneid="1" data-revive-id="6604a8d4427597fb692b1cc4f9b44d32" data-revive-seq="0" id="revive-0-0" data-revive-loaded="1" style="text-decoration: none;"><video class="img-fluid rounded-lg mb-3" autoplay="" muted="" loop=""> <source src="https://joyplan.it/adv/adv-2.mp4" type="video/mp4"></video><div id="beacon_ea4cd5cc9f" style="position: absolute; left: 0px; top: 0px; visibility: hidden;"><img src="https://revive.farweb-diplomarti.it/www/delivery/lg.php?bannerid=3&amp;campaignid=1&amp;zoneid=1&amp;loc=https%3A%2F%2Fstage.joyplanapp.com%2Fadmin%2Fdashboard_company&amp;referer=https%3A%2F%2Fstage.joyplanapp.com%2Fadmin%2Fplanning&amp;cb=ea4cd5cc9f" width="0" height="0" alt="" style="width: 0px; height: 0px;"></div></ins>
                    <script async="" src="//revive.farweb-diplomarti.it/www/delivery/asyncjs.php"></script>
                </div>
            </div>
            <div class="col-xl-4 d-flex flex-column" id="column-account">
                <div class="card card-dashboard d-flex flex-column flex-grow-1">
                    <div class="row no-gutters flex-grow-1">
                        <div class="col col-xl-9 col-xx d-flex flex-column order-2 order-lg-1">
                            <div class="card-body d-flex flex-column">
                                <div class="mt-auto">
                                    <div class="font-sm font-x3-lg">Ciao <strong>{{ \backpack_user()->name }}</strong>,</div>
                                    <?php
                                    $day_desc = config("cmsformula.days_desc");
                                    $day_d = $day_desc[\Carbon\Carbon::now()->format("D")];
                                    ?>
                                    <div class="font-lg text-dark">Oggi è <strong>{{ $day_d }} {{ \Carbon\Carbon::now()->format("d/m/Y") }}</strong> <span>|</span> <span>Ore {{ \Carbon\Carbon::now()->format("H:i") }}</span></div>

                                    <div class="line-height-sm">
                                        <strong>
                                            295
                                        </strong>
                                        (44.7%) Ore occupate
                                        <a href="#modal-risorse" data-toggle="modal" data-target="#modal-risorse" class="text-dark font-xs"><i class="icon-eye"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/page/create"> <img src="/img/icons/crea-pagina-03.png"><br>
                                Nuova pagina
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/page"> <img src="/img/icons/elenco-pagine-03.png"><br>
                                Elenco Pagine
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/elfinder"> <img src="/img/icons/media-03.png"><br>
                                File Manager
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/websiteSetting/1/edit"> <img src="/img/icons/setting-03.png"><br>
                                Impostazioni
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="/admin/pluginTutorial/view"> <img src="/img/icons/videotut-03.png"><br>
                                Tutorial
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

            <div class="col-sm-4 col-xl-2">
                <div class="card text-white">
                    <div class="card-body">
                        <div class="card-wrapper" style="text-align: center; width: 100%;">
                            <a href="https://www.webisland.it/contatti" target="_blank"> <img src="/img/icons/supporto-03.png"><br>
                                Richiedi Assistenza
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-->

        </div>

        <div class="row row-short flex-grow-1">
            <div class="col-md-12 col-xx-9">
                <div class="row row-short flex-grow-1">
                    <div class="col-md-6 d-flex flex-column">
                        <div class="card card-dashboard flex-column flex-grow-1">

                            <div id="carousel-top-5" class="carousel slide carousel-dash" data-ride="carousel" data-interval="6000">
                                <div class="carousel-inner">


                                    <div class="carousel-item">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Top 5 Servizi</h4>
                                                    <div class="font-xs mb-2">Ultimi 12 mesi</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Servizi</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0" disabled="">Servizi</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="4">Categoria</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Staff</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-servizi">
                                                <tbody>
                                                <tr>
                                                    <th>1°</th>
                                                    <td>
                                                        <strong>Trattamento lipolitico con Mesobooster</strong>
                                                        <div>€ 160,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>2°</th>
                                                    <td>
                                                        <strong>Calcoterapia</strong>
                                                        <div>€ 150,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>3°</th>
                                                    <td>
                                                        <strong>Mesoboost rassodante+ recoveri mask</strong>
                                                        <div>€ 120,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>4°</th>
                                                    <td>
                                                        <strong>Time Expert White con dermatech</strong>
                                                        <div>€ 110,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>5°</th>
                                                    <td>
                                                        <strong>Tone UP viso</strong>
                                                        <div>€ 110,00</div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="carousel-item">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Top 5 Prodotti</h4>
                                                    <div class="font-xs mb-2">Ultimi 12 mesi</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Prodotti</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Servizi</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="4">Categoria</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1" disabled="">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Staff</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-prodotti">
                                                <tbody>
                                                <tr>
                                                    <th>1°</th>
                                                    <td>
                                                        <strong>Prodotto TEST Scontrino</strong>
                                                        <div>€ 1,50</div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="carousel-item">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Top 5 Clienti</h4>
                                                    <div class="font-xs mb-2">Ultimi 12 mesi</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Clienti</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Servizi</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="4">Categoria</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2" disabled="">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Staff</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-clienti">
                                                <tbody>
                                                <tr>
                                                    <th>1°</th>
                                                    <td>
                                                        <strong>Veronica Kutas</strong>
                                                        <div>€ 8.744,98</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>2°</th>
                                                    <td>
                                                        <strong>Evelina Iemma</strong>
                                                        <div>€ 5.910,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>3°</th>
                                                    <td>
                                                        <strong>Faridè Villano</strong>
                                                        <div>€ 2.934,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>4°</th>
                                                    <td>
                                                        <strong>Maria Albanese</strong>
                                                        <div>€ 2.665,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>5°</th>
                                                    <td>
                                                        <strong>Giusy Adelizzi</strong>
                                                        <div>€ 2.304,00</div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="carousel-item">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Top 5 Staff</h4>
                                                    <div class="font-xs mb-2">Ultimi 12 mesi</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Staff</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Servizi</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="4">Categoria</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3" disabled="">Staff</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-staff">
                                                <tbody>
                                                <tr>
                                                    <th>1°</th>
                                                    <td>
                                                        <strong>Cabina Corpo Doppia</strong>
                                                        <div>€ 30.838,10</div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="carousel-item active">
                                        <div class="card-body">
                                            <div class="row row-extrashort">
                                                <div class="col">
                                                    <h4 class="line-height-xs">Top 5 Categoria</h4>
                                                    <div class="font-xs mb-2">Ultimi 12 mesi</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Categoria</button>
                                                        <div class="dropdown-menu dropdown-menu-right font-sm">
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="0">Servizi</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="4" disabled="">Categoria</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="1">Prodotti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="2">Clienti</a>
                                                            <a class="dropdown-item py-1 px-3" href="#" data-target="#carousel-top-5" data-slide-to="3">Staff</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-borderless table-sm table-classifiche line-height-sm mt-auto mb-0" id="table-top-cat">
                                                <tbody>
                                                <tr>
                                                    <th>1°</th>
                                                    <td>
                                                        <strong>Tecnologie estetica</strong>
                                                        <div>€ 12.969,40</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>2°</th>
                                                    <td>
                                                        <strong>Trattamenti Viso</strong>
                                                        <div>€ 9.433,00</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>3°</th>
                                                    <td>
                                                        <strong>Percorsi SPA</strong>
                                                        <div>€ 3.939,55</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>4°</th>
                                                    <td>
                                                        <strong>Trattamenti Corpo</strong>
                                                        <div>€ 3.625,18</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>5°</th>
                                                    <td>
                                                        <strong>Cura dei Piedi</strong>
                                                        <div>€ 3.595,00</div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 d-flex flex-column">

                        <div class="card card-dashboard flex-column flex-grow-1">
                            <div class="card-body">
                                <h4 class="line-height-xs">Saldo</h4>
                                <h4 class="line-height-xs font-4xl">€ 37.113,30</h4>
                                <div class="font-xs">Disponibile ad oggi</div>

                                <div class="hr my-2"></div>

                                <ul class="nav flex-column font-sm gap-1 mt-3">
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">Cassetto Contanti</div>
                                        <div class="ml-auto text-right text-nowrap">€ 26.262,30</div>
                                    </li>
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">BCC Battipaglia Montecorvino</div>
                                        <div class="ml-auto text-right text-nowrap">€ 1.089,00</div>
                                    </li>
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">Pos Sumup</div>
                                        <div class="ml-auto text-right text-nowrap">€ 46,00</div>
                                    </li>
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">Pos Cofidis</div>
                                        <div class="ml-auto text-right text-nowrap">€ 9.716,00</div>
                                    </li>
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">PagoDil</div>
                                        <div class="ml-auto text-right text-nowrap">€ 0,00</div>
                                    </li>
                                    <li class="nav gap-x-2 flex-nowrap">
                                        <div class="font-sm">Abbuono a cliente</div>
                                        <div class="ml-auto text-right text-nowrap">€ 0,00</div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xx-3 d-flex flex-column">

                <!--<div class="card card-dashboard flex-column flex-grow-1">
                    <div class="card-body d-flex flex-column">
                        <h4 class="line-height-xs">Magazzino</h4>
                        <h4 class="line-height-xs font-4xl">€ 623,25</h4>
                        <div class="font-xs mb-4">Disponibile ad oggi</div>


                        <ul class="nav flex-column font-sm gap-1 mt-auto">
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-success font-600">Buone</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-success font-600 w-40px text-right">2</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-dark">Basse</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-dark w-40px text-right">0</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-dark font-600">Scarse</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-dark font-600 w-40px text-right">0</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-warning font-600">Sottoscorta</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-warning font-600 w-40px text-right">0</div>
                            </li>
                            <li class="nav gap-x-2 flex-nowrap">
                                <div class="font-sm w-90px text-danger font-600">Esaurite</div>
                                <div class="progress-group-bars">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="text-danger font-600 w-40px text-right">0</div>
                            </li>
                        </ul>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
    </div>


    <div class="modal" id="modal-mappa">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <div class="modal-title font-lg font-600">Mappa Clienti</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="la la-close"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div id="map" class="map-dashboard"><div style="height: 100%; width: 100%;"><div style="overflow: hidden;"></div></div></div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal" id="modal-risorse">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <div class="modal-title font-lg font-600">Risorse (Ore occupate)</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="la la-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="font-600 font-2xl mb-2">Staff</div>
                    <div class="row">
                        <div class="col-lg mb-3">
                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Anna Napoli</div>
                                        <div class="ml-auto text-right">
                                            <div class="font-xs text-muted">44.7%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 44.7%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--
                        <div class="col-lg mb-3">
                            <div class="font-600 font-lg mb-2">Servizi da eseguire</div>

                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Staff 1</div>
                                        <div class="ml-auto text-right">

                                            <div class="font-xs text-muted">1.45%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 1.45%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Staff 2</div>
                                        <div class="ml-auto text-right">

                                            <div class="font-xs text-muted">1.45%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 1.45%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg mb-3">
                            <div class="font-600 font-lg mb-2">Clienti da servire</div>

                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Staff 1</div>
                                        <div class="ml-auto text-right">

                                            <div class="font-xs text-muted">1.45%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 1.45%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Staff 2</div>
                                        <div class="ml-auto text-right">

                                            <div class="font-xs text-muted">1.45%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 1.45%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                        </div>  -->
                    </div>

                    <hr>


                    <div class="font-600 font-2xl mb-2">Postazioni</div>
                    <div class="row">
                        <div class="col-lg mb-3">
                            <!-- <div class="font-600 font-lg mb-2">Ore occupate</div> -->
                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Cabina Corpo Singola</div>
                                        <div class="ml-auto text-right">

                                            <div class="font-xs text-muted">18.59%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 18.59%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Cabina Cera</div>
                                        <div class="ml-auto text-right">

                                            <div class="font-xs text-muted">11.54%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 11.54%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-group mb-2">
                                <div class="progress-group-bars w-100">
                                    <div class="progress-group-header">
                                        <div class="font-sm text-truncate mr-2">Postazione Mani</div>
                                        <div class="ml-auto text-right">

                                            <div class="font-xs text-muted">7.69%</div>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 7.69%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="font-600 font-2xl mb-2">Strumenti</div>
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('packages/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}">
    <link href="{{ url('/css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('packages/select2/dist/js/i18n/it.js') }}"></script>

    <script src="{{ asset('packages/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
@endsection

@section('footer')
@endsection


