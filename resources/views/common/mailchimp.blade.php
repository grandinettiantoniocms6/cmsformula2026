@if($website->mailchimp_user)
    <!-- Integration code -->
    @if(env('IUBENDA') == 1)

        <!-- With iubenda block provo a levare async class="_iub_cs_activate" -->
        <script id="mcjs" >
            !function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}
            (document,"script","https://chimpstatic.com/mcjs-connected/js/users/{{ $website->mailchimp_user }}.js");
        </script>

    @else

        <!-- Without iubenda block  -->
        <script id="mcjs">
            !function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}
            (document,"script","https://chimpstatic.com/mcjs-connected/js/users/{{ $website->mailchimp_user }}.js");
        </script>

    @endif
@endif
