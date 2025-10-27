@extends(backpack_view('blank'))

@section('after_scripts')

    @include('vendor.elfinder.common_scripts')
    @include('vendor.elfinder.common_styles')

    <script>
        (function($){
            // normalizza: 1) // -> / (senza toccare http://)  2) /uploads/s/ -> /uploads/
            function normalizeUrl(u){
                if (!u) return '';
                u = u.replace(/([^:]\/)\/+/g, '$1');
                u = u.replace(/\/uploads\/s\//, '/uploads/');
                return u;
            }
            // leggi parametri query (serve CKEditorFuncNum)
            function getUrlParam(paramName) {
                var re = new RegExp('[?&]' + paramName + '=([^&]+)');
                var match = window.location.search.match(re);
                return match ? decodeURIComponent(match[1]) : null;
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

                    // <<< OVERRIDE per CKEditor + doppio click
                    getFileCallback: function(file, fm){
                        var url = file && (file.url || fm.url(file.hash) || file.path || '');
                        url = normalizeUrl(url);

                        // se la finestra è stata aperta da CKEditor, rimanda l'URL pulito
                        var funcNum = getUrlParam('CKEditorFuncNum');
                        if (window.opener && window.opener.CKEDITOR && funcNum) {
                            window.opener.CKEDITOR.tools.callFunction(funcNum, url);
                            window.close();
                        } else {
                            // fallback: apri in nuova tab
                            window.open(url, '_blank');
                        }
                    },
                    commandsOptions: { getfile: { oncomplete: 'close' } },

                    // ripulisci anche subito dopo upload e all'apertura cartelle
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

                // patcha anche fm.url() per sicurezza
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
