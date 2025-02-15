<?php $thema = env('TEMA');
?>
@extends("$thema.layout")

@section('head')
    @include("$thema.inc.head")

    <script src="https://apis.google.com/js/api:client.js"></script>
    <script>
        var googleUser = {};
        var startApp = function() {
            gapi.load('auth2', function(){
                auth2 = gapi.auth2.init({
                    client_id: '{{ env('GOOGLE_ID') }}',
                    cookiepolicy: 'single_host_origin',
                });
                attachSignin(document.getElementById('google-btn'));
            });
        };

        function attachSignin(element) {
            console.log(element.id);
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                    var profile = googleUser.getBasicProfile();
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('google_sign') }}',
                        data: 'user_id='+profile.getId()+'&user_email='+profile.getEmail()+'&user_name='+profile.getName()+'&_token=' + token,
                        success: function (data) {
                            console.log("ok");
                            window.location.href = '/myarea/dashboard';
                        },
                        error: function(){}
                    });

                    console.log('ID: ' + profile.getId());
                    console.log('Email: ' + profile.getEmail());

                }, function(error) {}
            );
        }
    </script>
@endsection

@section('meta')
    @include("$thema.inc.meta")
@endsection

@if($website->is_online == 1 || backpack_user() || is_numeric(strpos(env('APP_URL'), "stage")))
    @section('topbar')
        @include("$thema.inc.topbar")
    @endsection

    @section('topbar_ecommerce')
        @include("$thema.inc.topbar_ecommerce")
    @endsection

    @section('header_menu')
        @include("$thema.inc.header_menu")
    @endsection

    @section('content_header')
        @include("$thema.inc.content_header")
    @endsection

    @section('content')
        @if(env('TEMA') == "Webshop")
            @include("$thema.plugins.pluginProducts.v3.login")
        @else
            @include("common.pluginProducts.login")
        @endif

        @include("$thema.inc.content")
    @endsection

    @section('content_footer')
        @include("$thema.inc.content_footer")
    @endsection
@else
    @include("$thema.inc.content_offline")
@endif


