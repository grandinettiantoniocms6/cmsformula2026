<!-- This file is used to store topbar (right) items -->

<!-- Per personalizzare la top bar con icone usare: https://icons8.com/line-awesome -->
<!--<li class="nav-item d-md-down-none"><a class="nav-link" href="https://www.webisland.it/contatti" target="_blank"><i class="las la-headset"></i></a></li>-->
@if(env('NASCONDI_FRONTEND') == 0)
<!--<li class="nav-item d-md-down-none"><a class="nav-link" href="/stat" target="_blank"><i class="las la-chart-bar"></i></a></li>-->
<li class="nav-item d-md-down-none"><a class="nav-link text-white" href="/" target="_blank" title="Anteprima Web"><i class="las la-eye"></i> Anteprima Sito</a></li>
@endif

{{-- <li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-bell"></i><span class="badge badge-pill badge-danger">5</span></a></li>
<li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-list"></i></a></li>
<li class="nav-item d-md-down-none"><a class="nav-link" href="#"><i class="la la-map"></i></a></li> --}}
