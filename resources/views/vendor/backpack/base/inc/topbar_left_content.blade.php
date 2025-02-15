<!-- This file is used to store topbar (left) items -->

<?php
$website = \App\Models\WebsiteSetting::first();
?>
@if(env('NASCONDI_FRONTEND') == 0)
    @if($website->is_online == 1)
        <li class="nav-item d-md-down-none"><span class="badge badge-success">SITO ONLINE</span></li>
    @else
        <li class="nav-item d-md-down-none"><span class="badge badge-danger">SITO OFFLINE</span></li>
    @endif
@endif

{{-- <li class="nav-item px-3"><a class="nav-link" href="#">Dashboard</a></li>
<li class="nav-item px-3"><a class="nav-link" href="#">Users</a></li>
<li class="nav-item px-3"><a class="nav-link" href="#">Settings</a></li> --}}
