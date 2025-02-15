<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
  @include(backpack_view('inc.head'))

</head>

<body class="{{ config('backpack.base.body_class') }}">

  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main pt-2">

       @yield('before_breadcrumbs_widgets')

       @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))

       @yield('after_breadcrumbs_widgets')

       @yield('header')

        <div class="container-fluid">

          @yield('before_content_widgets')

          @yield('content')

          @yield('after_content_widgets')

        </div>

    </main>

  </div><!-- ./app-body -->

  <footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
  </footer>

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  <script>
      function add_range(id){
          var code = Math.floor(Math.random() * 100001);
          $("#zona-"+id).append("<tr id='new-"+code+"'><td>Da <input type='text' class='form-control' name='min["+id+"][]' size='10'></td><td>A <input type='text' class='form-control' name='max["+id+"][]' size='10'></td><td>&euro; <input type='text' class='form-control' name='price["+id+"][]' size='10'></td><td><a href='javascript:delete_range(\"new\", "+code+")'><i class='fa fa-trash'></i></a></td></tr>");
      }

      function delete_range(type, id){
          $("#"+type+"-"+id).html("");
      }
  </script>

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>
