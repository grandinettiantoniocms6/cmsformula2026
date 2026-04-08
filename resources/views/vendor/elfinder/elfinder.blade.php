@extends(backpack_view('blank'))

@section('after_styles')
    <style>
        :root {
            --elf-shell-bg: #f5f7fb;
            --elf-surface: #ffffff;
            --elf-border: #d8deea;
            --elf-primary: #1d4ed8;
            --elf-primary-soft: #e8f0ff;
            --elf-text: #1f2937;
            --elf-muted: #64748b;
            --elf-shadow: 0 18px 40px rgba(25, 45, 80, 0.12);
        }

        .elfinder-modern-shell {
            background: radial-gradient(120% 120% at 10% 0%, #eef4ff 0%, var(--elf-shell-bg) 52%, #eef2f8 100%);
            border: 1px solid var(--elf-border);
            border-radius: 16px;
            box-shadow: var(--elf-shadow);
            padding: 10px;
            overflow: hidden;
        }

        #elfinder {
            min-height: calc(100vh - 240px);
        }

        #elfinder .elfinder {
            border: 0;
            border-radius: 12px;
            overflow: hidden;
            background: var(--elf-surface);
        }

        #elfinder .elfinder-toolbar {
            background: linear-gradient(180deg, #1f3b7b 0%, #1a2f5f 100%);
            border-bottom: 1px solid var(--elf-border);
            padding: 8px 10px;
        }

        #elfinder .elfinder-button {
            border-radius: 10px;
            transition: all .2s ease;
        }

        #elfinder .elfinder-toolbar .elfinder-button-icon {
            opacity: .95;
        }

        #elfinder .elfinder-button:hover {
            background: rgba(255, 255, 255, .16);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .22);
        }

        #elfinder .elfinder-navbar {
            background: #f7f9fd;
            border-right: 1px solid var(--elf-border);
        }

        #elfinder .elfinder-tree .elfinder-navbar-dir {
            border-radius: 8px;
            margin: 1px 8px;
            color: var(--elf-text) !important;
        }

        #elfinder .elfinder-tree .elfinder-navbar-dir:hover,
        #elfinder .elfinder-tree .elfinder-navbar-dir.ui-state-hover {
            background: #eaf1ff;
            color: #0f2655 !important;
        }

        #elfinder .elfinder-tree .elfinder-navbar-dir.ui-state-active {
            background: var(--elf-primary-soft);
            color: #0f3faa !important;
            border: 1px solid #c8d9ff;
        }

        #elfinder .elfinder-cwd-wrapper {
            background: #fff;
        }

        #elfinder .elfinder-cwd table thead td {
            background: #f8faff;
            color: var(--elf-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--elf-border);
        }

        #elfinder .elfinder-cwd-file {
            border-radius: 10px;
            transition: background-color .15s ease;
        }

        #elfinder .elfinder-cwd-file:hover {
            background: #f4f7ff;
        }

        #elfinder .elfinder-cwd-file.ui-selected {
            background: #e9f1ff !important;
            box-shadow: inset 0 0 0 1px #c6d9ff;
        }

        #elfinder .elfinder-cwd .elfinder-cwd-file .elfinder-cwd-filename,
        #elfinder .elfinder-cwd .elfinder-cwd-file:hover .elfinder-cwd-filename,
        #elfinder .elfinder-cwd .elfinder-cwd-file.ui-selected .elfinder-cwd-filename {
            color: #0f172a !important;
            text-shadow: none !important;
        }

        #elfinder .elfinder-statusbar {
            border-top: 1px solid var(--elf-border);
            background: #f8fbff;
            color: var(--elf-muted);
        }

        @media (max-width: 992px) {
            .elfinder-modern-shell {
                border-radius: 12px;
                padding: 6px;
            }

            #elfinder {
                min-height: calc(100vh - 180px);
            }
        }
    </style>
@endsection

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

                    /*getFileCallback: function(file) {
                        var url = file.url.replace('/s/', '/');
                        url = url.replace('//', '/');
                        window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, url);
                        window.close();
                    },*/

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
    <div class="elfinder-modern-shell">
        <div id="elfinder"></div>
    </div>
@endsection
