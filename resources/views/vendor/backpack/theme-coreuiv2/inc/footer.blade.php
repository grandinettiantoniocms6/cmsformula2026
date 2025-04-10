@if (backpack_theme_config('show_powered_by') || backpack_theme_config('developer_link'))
    <div class="text-muted mx-auto">
      @if (backpack_theme_config('developer_link') && backpack_theme_config('developer_name'))
      @endif
      @if (backpack_theme_config('show_powered_by'))
      {{ trans('backpack::base.powered_by') }} <a target="_blank" rel="noopener" href="http://backpackforlaravel.com?ref=panel_footer_link">Backpack for Laravel</a>.
      @endif
    </div>
@endif