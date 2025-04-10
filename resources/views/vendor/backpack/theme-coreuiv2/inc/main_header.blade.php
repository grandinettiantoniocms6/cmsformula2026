<header class="{{ backpack_theme_config('classes.header') }}">
  {{-- Logo --}}
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <i class="la la-bars"></i>
  </button>

  <?php $website_setting = \App\Models\WebsiteSetting::first(); ?>

  <a class="navbar-brand" href="{{ url(backpack_theme_config('home_link')) }}" title="{{ backpack_theme_config('project_name') }}">
    @if($website_setting->logo_admin)
      <img src="{{ url($website_setting->logo_admin) }}" height="55">
    @else
      {!! backpack_theme_config('project_logo') !!}
    @endif
  </a>

  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <i class="la la-bars"></i>
  </button>

  @include(backpack_view('inc.menu'))
</header>