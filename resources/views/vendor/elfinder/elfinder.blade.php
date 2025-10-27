@extends(backpack_view('blank'))

@section('after_scripts')

    @include('vendor.elfinder.common_scripts')
    @include('vendor.elfinder.common_styles')

    <script>
        (function($){
            function normalizeUrl(u){
                if (!u) return '';
                // 1. collassa // in / (tranne in http://)
                u = u.replace(/([^:]\/)\/+/g, '$1');
                // 2. rimuovi /s/ se appare dopo /uploads/
                u = u.replace(/\/uploads\/s\//, '/uploads/');
                return u;
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

                    // se usi "Scegli" altrove
                    // ⬇️ QUESTA è la parte che gestisce il doppio-click di CKEditor
                    getFileCallback: function(file, fm){
                        var url = file && (file.url || fm.url(file.hash) || file.path || '');
                        url = normalizeUrl(url);

                        var funcNum = getUrlParam('CKEditorFuncNum');
                        if (funcNum && window.opener && window.opener.CKEDITOR) {
                            // ritorna l'URL NORMALIZZATO a CKEditor
                            window.opener.CKEDITOR.tools.callFunction(funcNum, url);
                            window.close();
                        } else {
                            // fallback quando non sei dentro CKEditor
                            window.open(url, '_blank');
                        }
                    },
                    commandsOptions: { getfile: { oncomplete: 'open' } },

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

                var fm = $node.elfinder('instance');

                // Patch fm.url() -> sempre URL normalizzato
                var _url = fm.url;
                fm.url = function(hash){
                    return normalizeUrl(_url.call(fm, hash));
                };

                // ✅ Override del comando "open" per i file (non directory)
                var openCmd = fm.getCommand('open');
                if (openCmd) {
                    var origExec = openCmd.exec;
                    openCmd.exec = function(hashes, opts){
                        hashes = hashes && hashes.length ? hashes : fm.selected();
                        var file = hashes && hashes.length ? fm.file(hashes[0]) : null;

                        // se è un file (non cartella), apri con URL ripulito
                        if (file && file.mime !== 'directory') {

                            var url = file.url || fm.url(file.hash) || file.path || '';

                            url = normalizeUrl(url);

                            window.open(url, '_blank');
                            return $.Deferred().resolve();
                        }

                        // altrimenti comportamento standard (aprire cartelle)
                        return origExec.call(this, hashes, opts);
                    };
                }

                // In più, normalizza qualsiasi URL emesso dall'evento 'url'
                fm.bind('url', function(e){
                    if (e && e.data && e.data.url) {
                        e.data.url = normalizeUrl(e.data.url);
                    }
                });
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
