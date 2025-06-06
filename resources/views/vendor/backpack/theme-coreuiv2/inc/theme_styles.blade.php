@basset('https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css')
@basset('https://unpkg.com/@digitallyhappy/backstrap@0.5.1/dist/css/legacy.css')

{{-- Source Sans Font | this definition shouldn't change as the inclusion of the font in css depends on relative file paths --}}
@bassetArchive(base_path('vendor/backpack/theme-coreuiv2/resources/assets/fonts/source-sans-3.052R.tar.gz'), 'source-sans-pro')

{{-- This file path shouldn't change as the inclusion of the font in css depend on this file relative path --}}
@basset(base_path('vendor/backpack/theme-coreuiv2/resources/assets/css/source-sans-pro.css'))

{{-- Custom Backpack Rules --}}
@basset(base_path('vendor/backpack/theme-coreuiv2/resources/assets/css/coreuiv2.css'))

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="{{ url("css/admin.css") }}">

<link rel="stylesheet" type="text/css" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css">
