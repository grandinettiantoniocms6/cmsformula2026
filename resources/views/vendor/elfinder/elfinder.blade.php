@extends(backpack_view('blank'))

@section('after_scripts')

    @include('vendor.elfinder.common_scripts')
    @include('vendor.elfinder.common_styles')

    <script>
        (function($){
            function normalizeUrl(u){
                if (!u) return '';
                u = u.replace(/([^:]\/)\/+/g, '$1');      // // -> /
                u = u.replace(/\/uploads\/s\//, '/uploads/'); // /uploads/s/ -> /uploads/
                return u;
            }
            function getUrlParam(name){
                var m = new RegExp('[?&]' + name + '=([^&]+)').exec(window.location.search);
                return m ? decodeURIComponent(m[1]) : null;
            }

            $(function(){
                var $node = $('#elfinder').elfinder({
                    @if($locale) lang: '{{ $locale }}', @endif
                    url: '{{ route("elfinder.connector") }}',
                    customData: { _token: '{{ csrf_token() }}' },
                    uiOptions: { theme: 'smooth' },
                    cssAutoLoad: false,
                    height: $(window).height() - 150,
                    theme: 'default',
                    soundPath: '{{ Basset::getUrl(base_path("vendor/studio-42/elfinder/sounds")) }}',

                    getFileCallback: function(file) {
                        var url = file.url.replace('/s/', '/');
                        url = url.replace('//', '/');
                        window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, url);
                        window.close();
                    },

                    // IMPORTANTISSIMO: non 'open', usa 'close' (o togli la riga)
                    commandsOptions: { getfile: { oncomplete: 'close' } },

                    handlers: {
                        upload: function(ev, fm){
                            var added = (ev.data && ev.data.added) || [];
                            added.forEach(function(f){
                                if (f.url)  f.url  = normalizeUrl(f.url);
                                if (f.path) f.path = f.path.replace(/^\/+/, '');
                            });
                        },
                        open: function(ev, fm){
                            fm.files().forEach(function(f){
                                if (f && f.url) f.url = normalizeUrl(f.url);
                            });
                        }
                    }
                });

                // robustezza extra
                var fm = $node.elfinder('instance');
                if (fm) {
                    var _url = fm.url;
                    fm.url = function(hash){ return normalizeUrl(_url.call(fm, hash)); };
                    fm.bind('url', function(e){ if (e.data && e.data.url) e.data.url = normalizeUrl(e.data.url); });
                }
            });
        })(jQuery);
    </script>
@endsection

@php
    $breadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      trans('backpack::crud.file_manager') => false,
    ];
@endphp

@section('header')
    <h3 class="page-title mb-0">
        <span class="text-capitalize">{{ trans('backpack::crud.file_manager') }}</span>
    </h3>
@endsection

@section('content')
    <div id="elfinder"></div>
@endsection
