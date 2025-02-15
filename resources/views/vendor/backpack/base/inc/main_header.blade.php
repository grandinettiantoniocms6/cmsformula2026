<header class="{{ config('backpack.base.header_class') }}">
  <!-- Logo -->
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto ml-3" type="button" data-toggle="sidebar-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
      <i class="la la-bars"></i>
  </button>
  <?php
    $website_setting = \App\Models\WebsiteSetting::first();
  ?>

  <a class="navbar-brand" href="/admin/dashboard" title="{{ config('backpack.base.project_name') }}">
    @if($website_setting->logo_admin)
        <img src="{{ url($website_setting->logo_admin) }}" height="55">
    @else
        {!! config('backpack.base.project_logo') !!}
    @endif

  </a>
  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
      <i class="la la-bars"></i>
  </button>

  @include(backpack_view('inc.menu'))
</header>
