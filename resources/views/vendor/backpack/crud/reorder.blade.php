@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard')
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.reorder').' '.$crud->entity_name_plural !!}.</small>

        @if ($crud->hasAccess('list'))
            <small><a href="#" onclick="history.back()" class="d-print-none font-sm"><i class="la la-angle-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
    </h3>
@endsection

@section('content')
<?php
function tree_element($entry, $key, $all_entries, $crud)
{
    if (! isset($entry->tree_element_shown)) {
        // mark the element as shown
        $all_entries[$key]->tree_element_shown = true;
        $entry->tree_element_shown = true;

        // show the tree element
        echo '<li id="list_'.$entry->getKey().'">';

        if($crud->get('reorder.label') == "attribute_id"){
            $item = \App\Models\PluginProductsAttributes::where("id", object_get($entry, $crud->get('reorder.label')))->first();
            if($item){
                echo '<div><span class="disclose"><span></span></span>'.$item->name.'</div>';
            }
        }else{
            echo '<div><span class="disclose"><span></span></span>'.object_get($entry, $crud->get('reorder.label')).'</div>';
        }

        // see if this element has any children
        $children = [];
        foreach ($all_entries as $key => $subentry) {
            if ($subentry->parent_id == $entry->getKey()) {
                $children[] = $subentry;
            }
        }

        $children = collect($children)->sortBy('lft');

        // if it does have children, show them
        if (count($children)) {
            echo '<ol>';
            foreach ($children as $key => $child) {
                $children[$key] = tree_element($child, $child->getKey(), $all_entries, $crud);
            }
            echo '</ol>';
        }
        echo '</li>';
    }

    return $entry;
}

?>

<div class="row mt-4">
    <div class="{{ $crud->getReorderContentClass() }}">
        <div class="card py-3 px-4">
            <h5 class="text text-primary mb-0">{{ trans('backpack::crud.reorder_text') }}</h5>

            <ol class="sortable">
            <?php
                $all_entries = collect($entries->all())->sortBy('lft')->keyBy($crud->getModel()->getKeyName());
                $root_entries = $all_entries->filter(function ($item) {
                    return $item->parent_id == 0;
                });
                foreach ($root_entries as $key => $entry) {
                    $root_entries[$key] = tree_element($entry, $key, $all_entries, $crud);
                }
            ?>
            </ol>

        </div><!-- /.card -->

        <div id="saveActions">
            <button id="toArray" class="btn btn-success" data-style="zoom-in"><i class="la la-save"></i> {{ trans('backpack::crud.save') }}</button>
        </div>
    </div>
</div>
@endsection


@section('after_styles')
<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/reorder.css') }}">
@endsection

@section('after_scripts')
<script src="{{ asset('packages/backpack/crud/js/crud.js') }}" type="text/javascript" ></script>
<script src="{{ asset('packages/backpack/crud/js/reorder.js') }}" type="text/javascript" ></script>
<script src="{{ asset('packages/jquery-ui-dist/jquery-ui.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('packages/nestedSortable/jquery.mjs.nestedSortable2.js') }}" type="text/javascript" ></script>

<script type="text/javascript">
    jQuery(document).ready(function($) {

    // initialize the nested sortable plugin
    $('.sortable').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        maxLevels: {{ $crud->get('reorder.max_level') ?? 3 }},

        isTree: true,
        expandOnHover: 700,
        startCollapsed: false
    });

    $('.disclose').on('click', function() {
        $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
    });

    $('#toArray').click(function(e){
        // get the current tree order
        arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});

        // log it
        //console.log(arraied);

        // send it with POST
        $.ajax({
            url: '{{ Request::url() }}',
            type: 'POST',
            data: { tree: arraied },
        })
        .done(function() {
            new Noty({
                type: "success",
                text: "<strong>{{ trans('backpack::crud.reorder_success_title') }}</strong><br>{{ trans('backpack::crud.reorder_success_message') }}"
            }).show();
          })
        .fail(function() {
            new Noty({
                type: "error",
                text: "<strong>{{ trans('backpack::crud.reorder_error_title') }}</strong><br>{{ trans('backpack::crud.reorder_error_message') }}"
            }).show();
          })
        .always(function() {
            console.log("complete");
        });

    });

    $.ajaxPrefilter(function(options, originalOptions, xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-XSRF-TOKEN', token);
        }
    });

});
</script>
@endsection
