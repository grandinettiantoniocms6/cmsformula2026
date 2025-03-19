<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

        /* Variables */
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }

        body {
            line-height: 1;
            font-family: "Roboto", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, Fira Sans, Droid Sans, Arial, sans-serif;
        }

        ol, ul {
            list-style: none;
        }

        blockquote, q {
            quotes: none;
        }

        blockquote:before, blockquote:after,
        q:before, q:after {
            content: "";
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        strong, b {
            font-weight: 700;
        }
        .center {
            text-align: center;
        }

        /* mini - medium - large */

        #wrapper-small {
            width: 710px;
            padding: 35px 0;
            background-color: #F4E0B9;
            margin: auto;
        }
        #logo-container img {
            display: block;
            margin-bottom: 35px;
            width: 100%;
        }
        #title-container {
            margin-bottom: 20px;
            text-align: center;
            color: #7d5943;
            letter-spacing: -0.4px;
            padding: 0 25px;
        }
        #title-container h1 {
            font-size: 38px;
        }
        #recipe-container, #description-container {
            margin: 20px 0;
            text-align: center;
            color: #7d5943;
            padding: 0 25px;
        }
        #recipe-container h3 {
            font-size: 28px;
            line-height: 36px;
            font-weight: 300;
        }
        #description-container h2 {
            font-size: 30px;
            font-weight: 300;
        }
        #produced-container {
            margin-top: 50px;
            margin-bottom: 35px;
            text-align: center;
            color: #7d5943;
            padding: 0 70px;
        }
        #produced-container h2 {
            font-size: 26px;
            font-weight: bold;
        }
        #footer-container {
            margin-top: 35px;
            margin-bottom: 35px;
            background-size: 672px 193px;
            background-repeat: no-repeat;
            background-position: center center;
            height: 193px;
        }
        #qr-code {
            margin: 0 150px;
            width: 193px;
            height: 193px;
        }
        #address-container {
            padding: 0 15px;
            color: #7d5943;
            line-height: 30px;
            font-size: 22px;
            font-weight: 300;
            text-align: center;
        }
        #address-container .title {
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 22px;
        }
        #weight-container {
            margin: 35px 5% 0;
            color: #7d5943;
        }
        #weight-container .small-border {
            border-top: 1px solid #DEC7A4;
            margin: auto auto 15px;
        }
        #weight-container table {
            margin: 0 auto;
            text-align: center;
            font-size: 32px;
            color: #7d5943;
            font-weight: 300;
        }
        #weight-container table td {
            padding: 5px 15px;
        }

        #tabella-nutrizionale {
            margin: 35px 0;
            padding: 0 70px;
        }
        #tabella-nutrizionale table {
            width: 100%;
            color: #7d5943;
            font-weight: 300;
            text-align: left;
            font-size: 26px;
        }
        #tabella-nutrizionale table th,
        #tabella-nutrizionale table td {
            padding: 5px;
            border: 1px solid #DEC7A4;
        }

        table.layout {
            width: 100%;
        }
        table.layout td {
            text-align: center;
            vertical-align: middle;
        }

        .label-container {
            display: table;
            width: 33.2%;
            height: 49.5%;
            background-color: #f7f7f7;
            border: 1px solid #fff;
            float: left;
            vertical-align: middle;
            text-align: center;
        }
        .table-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .label-container .label-wrapper {
            margin: auto;
        }
        .clearfix {
            overflow: auto;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>

    <title>Pasticceria Righetto - Eetichette</title>
</head>
<body>

@php $max = 5; @endphp
@if($label->format == 'mini')
    @php $max = 6; @endphp
@endif

@for ($i = 0; $i <= $max; $i++)
    <div class="label-container">
        <div class="table-cell">
            <div class="label-wrapper" id="wrapper-small">
                @if($setting->logo && $label->is_logo_header)
                    <div id="logo-container">
                        <img src="{{ url($setting->logo) }}">
                    </div>
                @endif

                @if($label->title && trim($label->title != ""))
                    <div id="title-container">
                        <h1 id="title">{{ $label->title }}</h1>
                    </div>
                @endif

                @if($label->ingredients && trim($label->ingredients != ""))
                    <div id="recipe-container">
                        <h3 id="recipe">{!! $label->ingredients !!}</h3>
                    </div>
                @endif

                @if($label->description && trim($label->description != ""))
                    <div id="description-container">
                        <h2 id="description">{!! $label->description !!}</h2>
                    </div>
                @endif

                @if($label->is_product_lab)
                    <div id="produced-container">
                        <h2 id="produced">Prodotto in laboratorio che usa anche nocciole, frutta con guscio, latte, uova</h2>
                    </div>
                @endif

                @if($label->is_product_lab)
                    <div id="tabella-nutrizionale">
                        {!! $label->table_nutr !!}
                    </div>
                @endif

                @if($label->qrcode_link && trim($label->qrcode_link != ""))
                    <div id="footer-container" style="@if($setting->photo) background-image: url({{ url($setting->photo) }}); @endif">
                        <div id="qr-code">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMEAAADBCAYAAAB2QtScAAAAAXNSR0IArs4c6QAAH9lJREFUeF7tXXuUJGV1/93qYbMYlfURIRIF9QjxAWiUxSe729W7nmggxuPsdjWPEBWPRlDP0RVxpoZhqscnasJiYgKSI4+u3l01EUwIu10N+IgiGl00KqgBNIlLVFxUlF2m6+bUrBKmvu8bvrtdw8yyt/6sunW/r27dW/dR90FxFDKW9rErSbPHDLvFiajRZvBYGQ8Rr5/q9LcOg3+sVT8iYLrdFweBN02l/TeX4eNmYxOIz/LF44C7N0mzg8vXJqPw2AGwY0jcxe2nJWl2hS+eOAp3ATjEF34x4EiFQIVAyHgqBEKCVQGumkBGRdUEMnpBNYGaQ0KWUXNISrAq4FUTyKiomkBGL6cmuAfgr5i4iAEmy/kc4MB/bSeeVRYcdydptqJ8/h2vefGjlv3q4OeZji4xs7lHIn4tgFPL8MwYbXezT/jufaxVP5HyYO6zEq8g8FstdCn2fZxxnnBh0sneUj4/0QovYsabjD0CXyfw3X50pz1Jmq0zHONW46kDzi8VvNMnAXiqQV/QdM7olc/vecSvv/r+S7/wi/J5t2PMN/g9TwFFUv6ywxMdD8YjjGdyOMa3Jml2tC9jVAUXR+GdAJ5QwmcVgrFWfWXAdOOwa0uFII7C3QCWlda9I0mzI8t7Gd9QX0cBXWvskemipNs721cICFg3lWbbh31Wyf1xszEO4sT7nhwrk83ZTRYhKIT30aXzdyZpdpg37ooA4yi8FcDTVQhKFFAhsHOYCgGgmsDx9VFN4CCMaoJq9JWaQ3afQM2hyvhLzSEbKdUcUnPI9Z/gliTN/rBMnnNPDx9X20PHGI4F2SMyLvm9b4CvvW9rz4h2xFG4E8ChPo5xvCE8HgG+bFljJ8C3+H87aucl6XZLpMLBHFG4DeA5jjET7Wx3smb5jrHm2ucHNLigfJ4RfLKd9jb5OsZMtLbd6RkRmbFTGi+gAZY/EA8HeT7d6X/W9/nPHf3j36vV7nuWCc+nEqGIqPkdbnPIljZhdYzPGW0cclANzx2WvwbL+BvvuSz7qcVJL/jiqKEc44mofhKDrvKjyjxQjBOTbvY5yya9o0Nxc80JoOBLBoMRXd7u9E4feo+LgMAVInWZQ3ErvAOMJ5e2ujtJszmCMd+jTLTqo8y0ZejHrcAnKMLPAZP3B8m1Zw5wUvvK7DMW/hreHFIhGJpV5kWgQqBCAIljrJoAUE1g/6aoJlBzSM0hNYfUJ1CfoBqfwBodGm+uOZko+PSwlnFOvMoWwZBEh8ZG64fXDgrO9N3LAHlfEjUZbzXeGJiRKkx1epPlNSfPWL0i3zNi5g7l+fenuv3LjahRq76yhuDlvnvP85yDIDBytpi5yD8y8qqI6HwjYJDnO5Nu/6Oms9hYD/Bm372A+VMUBN8oww/uyy+e3tr/b4sz6h0dUscYEPkErpcWtxqng/njxnWmOOn22r4vO47CmwEY4eBdu5Yt33TNNUX+0P3HZHP1kQOq3WbBvd2WzDYeNc4m8IUGPPHZSad/kYWRtgFY67t3B9yOJM2eU762D9EhaVGNd+6QCoEKAaBCoCFSSXRINYFYL6gmqCKLdCn9J1AhUCE44H+WqRCoECy0EOy30SFmLiq5Xmkh0HVEZOTUBMRbJq/MvmVxRq2OcZJmRpRmHsf4P4nIiA65oj0D5P8y3ekb+VDxbL6S6RgT8YeB4Oc+4uBa08lIzC8FULdclzrGGh2yErmC3KGFriyTRIeq6jvk1G5RWFSVNcrXc+Ijpzv9O3yEIN6w5jgEwdfLsMzY2u5m68vnx1thTIyp8nliPt0W9p1n7xodUiEwKeBqvqVCoLlDov8EqgkA1QT2z8YBkzukQqBCsNCOsbXGeCmFSFUIVAgWWgj238oyom2c4z2GQyfsOzQehTsIOLaMxxodOmP18pl7R15gvBTi5xFgVJbB0XfI9VKLZrozTI+1PNNbAC41K7b3HYpPaRyDnIuIV+ngLUna31A+Wzj7lAdPsTjj3353mhXFT16Ho+/Q/ltZ5vXUQwBJ/hhL6wmkXakl0SHXI0v7DklJJ6knkEaHpHupIjpU1Zrz7GX4yrKHYJMLVl6pQiALkVb1ruMo9A6RVrWmCoGjqEaFQIXgYdeBTs0hWXmlmkOzqfpqDkkm1ahPUI1xsj+bQ9VQoBos1tbsS0kTPARFNd5pE5NnrF4+2F37tREDAm5up5nRITuOHJVlxO2k04/LeOIoLHKhjO7eOfEJjrwnHddUgRyoEAhyh1QI5By3306qUU1g/1mmQqBCAF6E6JCaQ7MCqeaQXP6871BzSM0hb2bZF0A1hxyD+yTRIdUE+7km2BfJWQr3SH2CuFVPwDTuvfeAjk2u7Bn9dWz3S4XAtQdXL1IXvCuVWjab2p47VFVRjTe9FxHQMoRvEXcjWFqFwJ1FqkIgYKRiLKAMfOlAqxCoEFTFjSoELkqqOVRJjXFVjLqQeFQIVAis9QQHlE8w3mysLvMBOcYvjXDwk8nN275Zhh9rrnsSIX9a+Xw+Urvl3Vdc+yNfKR5r1l9ECMozgq23E/BEUP56Mz2Arm2nmVFUM9EKX8vMp5nIqBhLVR4RBQK/JufA6C9qow0FfBgYqYGbaFvS6b3MoNdo/XCqBeY8XZptsGu0i2HgZgL/rIynNjKyfvLybf9bPh9H9euNdwo6mIGV5vPbHeN5RriKWq6MRY2XEGPEhwfcfMf/M7k5K5Lf5hzjG+pPAwXF0PE5hwvPPYN7bvzw1i8aKSXCECldlaS9PzU2EzU2Evj9FgKfmaT9S3wIUMA4impcQvDlqTQ7wRe3C268GW4hwuiweOybtAtB3KqfBSZjZplrD66ZZZI9S7NIq9IE7on2/rtn8MXttG988OJW4wNgfrsvJqbgqHZn+3cNoZFFElQIfAk+C+fQBCoEIipChcBBLwJUEwh4STUBoJrAwTBqDi14B7qhU6lVE6gmKJICrXOMBYoAqgnm1QRmJAGgHODAcCBA38mZugbxiV9IYCMKQhx8YKrb+2fflxVH4acANlqL2O+nHzLTx3wjAxzkt9n6dsZRfTNARi/OefZ8fUFOr2ei4Kak09tYhpX6BADexkz/XsbT7vaMKFABY4v4BZQ/hUGXWoIX1hCpKzpEoOmcYQwWd0VkiPhqAI+0rGuZV+zku6/kTMZc4oB4HYNfZOK242EKLkSOu0y+9nqbe4GcM8uILrC9bAFqMai0+RaDx9tpf7q8kNQcsvUdkm5+H4TAukQwQ0ecv7X3A0PIopD99yQOkfqjdkPuTNLs930RTTQbZzLx3xvwzBuTbt/s6+RA7Kwx9t2ICsFeSqkQSDjGCatCUAUZVRMAqglUE6wMmG70FSg1h1yUUnPIz8H7Df3UJ1BzyPej8yBwD0NziPkLFARGxMBFiAHyf7BGapr1t1MQWCIJJibp+CHXMO/92TGWjGtCnj+Bid5oeSffIqKt5fMu+krpzsznAFhewn8PEXk7tMx4LsAnLwnHeJFas1tlabH+GC8lx9jxkbk3SbODy9eKztYDYIfvl5wYyVQ3m/CFd8FVkTvkNOSAt7fT7IO+e6wkOqRCsLTMIRUCFYJFyR1STeD73d0Lp5rArcdOTLrZ58qX94dUahUCFYKTGHSVjAwWaNkIV/UJZARXn8BBL5FPMHnK6j8Y5MEVZVzkyB1y541gI8AvN716WDWBtbKsxo+kHEX+Sfm4G2BjLi9A7J3bM4vRXlk2D98ZuUNMtLPdyZrle8aaa58f0MASBaEiZeAoYw3ChZzTPxp0d1T6WekeYIQ4N1rLkLOyDNcxkzGvGAG/lJhDkw72vJwaRt4wmW77jkW7S7JIdzDTW32fnxF8f7q77YfGms1wGsQvNulLx4PxCJOvLW97/NQ1R9MgMB4IwNVJmpmhKgfHjDfDS4jw2vLlnHjVdKdvTJe3oTlntHHIshEuCLmUj9uTNDPme01E4VoGimn0Xgczzmp3s494Ac8DJCuUquhnWY6VyebspuGEgG9I0r5R7iulRxyFhbVyku991p9lKgS+5LsfToVAhcDONKoJVBPIokOqCaySpOaQWCsVYcmHPpVaNYFqAvUJ9mOfwNqjhul3mGAOp4a924TrW+Uyh+AOkZqVZUXPGiLT03d/IK9lpveaEQYuHHRjzJALjbvvEF9nueeOJM2OLJ9/Z+sljxnJlxsjkgLiVzJQ9BiaezB9D5T/t3Ge+G1J57qv+ugE15AO970VOcbAVwH+pbkOrbKc+xkzXlU+Xwto1/md7UbEb6LZeAVTblToEdPfTnWzzWU8kxvWPXuG8sdbeOAyAGafIpnqrEYIXNGhOAp32hph+bz8B8BclqTZnxtRioq6UsdRuBtAuUGYVQhc+5ZWlklrjGXvtDIhkLympZVFKiOYCoEKgYTXnbAqBKoJFrYDnezDppqgkjaMUp9AhUCFYEkV2su+GmoOqTn0MDSHJI9UWT2BY9HaSO3QcpflffhPYHWMnU5qFBZVVa82IhXAcZNpdrPhYFfgGEtoPh9sHIW3AzjCE9+OJM2eYz6PbJi351r3g0km2o+16icGTJZ+RNJVZfCiGmMVgtn8+KGjQ7JX5IZWIaiGkioEqgnWA2zE2kHcTjr9eFg2U00gpKCaQzKCqSaQ0csFrZpANYFqAoksqU+gPoGEXwrY/dYcmtwQHjUIcIvvAxPwgak0e4cv/EQU3sDAib7wiwLnmF5ZhWMsTZtwPb+tDaMrd6iYe9ZOMyOPaaJVH2WmLQIai2aW2fC+KwoPrQFFisxQBztarsTN8GoQ/sSI+OU42jb7zGoOqRAAUCFwMagKgY0yqgmwoAl0qgnsFFBNMJQi9bhZNYFqAvUJ6Njkyt43ypygPgEOEHPI0XIFoGKU0jFlxmBQCoYxScQ1zDtuhX8NZsNJc42Jsptg9LsMPN9ybSfA3k69s+WKWxPYShfvZCaj5coI8V221IuJZv3PmCxFNaBiwPcTPfTULEjOtSdbW45YhnkD9CNm+jsTd76KiCZ915SPayJmLo23CvBYYv6kuSb9DMiNVJW9NSazrXHmHo5JNXHU+LStga9zeqXvwxdw0hApEV431cmMuWKSNV2wcXPNCaDgSwZdiC5vd3qn+64Ry/8T+NfvOuYYu5+psQnEZ/nu3TWkw3a/tCGv7x6qhbMX2kvHNVUSHXI9mArBbNxbhaBazn8ANhUCEWlVE7jHNakmqOA/gWoCoOZOpVZNIPpcSYBVE0ioBdUEqgngcoyr+GPs4saiPWOQ1yLDGQVeCOZ15n18ZpL2L/Hl7riKcU15vmOq2zea2jq1W6s+CgTP8t2jaFxRnn9/qtu/vIy7mLxZQ2A0KuaieTHjeMteLiOi28rnhXtxjWvyffQHg7uEiIx2MZJxTdIRUYM83zbd7f9beWMTUT0CBUc/2IZ/e12UReoUjqixkcDvH1oIRC1X6MYk7Vl6I/k++vxwcRQWoTojHLxr17Llm665piis2edDmjvkarkiTKXe5/163ejuQHc3gEeXcNyZpNlhZbxxtHYVkF9vWe+SJM3O9NrHPECi1uzSxcZVCEQkUyGACoGLY2TNt1QTqCYQfXuK8PatAIofknMONYccdFRzSMZgUHNIfQIJy6g5tMTMoYlWw8gbYeQ/STr9i3xfbDFmqRYEluiQHcNiDPN2PUtAvGXyyuxbppNmd4xtg/smz1i9It8zYowZgiM65BQCwjUE+nJ5LwFw2WSn95/mHutvJQpWeL0n4TBvZn4pgLoX7r1A1uiQLeLDef7LpNs3xliNtepH1BD8RXlNURSsKAUZcMdWPDMeNc4OCI8zzCFHGsCtSZp5h5hchKpiSIcLdxFmDJhuFLwkKygzRtvd7BO+QmCLDk02Vx85oJoRwgSwPUkz4+NQvAwCX2hsiPhsycdH8uzxhjXHIQiMjs/M2NruZuuN5282xkGcSNawwdaCZYdMXnnNz4fB48wdciAl8MlTad825856h6sNowqBIESqQuBmcRWCCgb3qSYY5hv6//eqJnDTUTWBmkNqDqlPoD6B+gT2/Ph7AP6KqUDsg7KLyrJ2mhlVS0WuEWZqxeDqOcd9A3ztfVt7xe/0OUcchea4Jqfz46wss45rcinDIOBXM/OzLc/6PACPLJ93RIeWz9w7YqRwuCrLxkbrh1MtMH7aBMQvZ/BKi8PsPa7J9ZzxKY1jkLOtaut/Af52+T6i4Po8h5HC4B7czn8D4BllPLsPvvfR77/0C78YxqiLo/rrALrYpAt9lHMYLSQD4iaDzUo0x6B34XwC+6NIu004X5Qod8hJVlFX6vFmuIUIo74vySYEvvc+GNxEK7yIGW8yGBJYN5Vm2x/s/vmuSyvLiJFMdbMJ3zXjVvhlW/LfnhlaYfvg+eIt4MSVZdJh3qJKKedXWdZ8S4XATgEVAgddmo0zmdioYXemUqsQQDWBhZdUE7h1j5pDag5ZuUPNIYnBBkB9AiHBHOBqDi2SOWRbtojq0CD4juXa1UmanTzsK4+j8LMAityUOccAOOzdaXbnA0/uw7gm6/YYPN5O+9O+e5dkkUr/GDt9oubCtVyR/ixz7XG81biMmE/zpaMDzjrCVTquydWGUbo3ayq1CsFsaxXvyjIVAinbQYVANYGdaWLVBKLBfaoJhB8fNYdkWaRqDqlPoOaQQwrUJwDUMbZ0m1CfQKiWscR8goX8YywtqomjsIgMPaFE0ruTNDOqpxa6qGaev9r+HegcSAi8aSrtv1nMOqUb4lZ4BxhPLp3enaTZ8jLuxYoOLWg9QVXNt1QI7FmkKgR2CkjNIRUCYVGNagKZblBNwBtttcri1uyqCVQT2OoJqooOqSZQTWDlJfUJZBpPnEotbcgbW0b7ENPvMEHS57NrGwVEhI0omsyWD8aJSTf7nOG8WYtq6JdJmhkzaeMN4fEIYLQnwex8XP9xTUzBZuQwikruPSi46YLLt91j2aPDMeYbzFfrKkIKPtlOe5tkrGBCj7fCLjHP7elJmOE8aJehiYqAQ/6XxqtgXNfu9s/33UschR8H4D0JiCl/BfLarx6In5HvsTXSde1hotl4BVO+0bhOtI1zMhryuopqmIILkeMugza2haVzjH0JeD+cQwgkeBaxNXvRjHdZaa+iEa6S55TCSod5S/FLHWMHfmvahHQvE1F4AQNvM5na3nJF1IZRhWDeIR0qBAuUQKdCIKSAagI7wVQTFKn9qgkWenqlagLVBMJPtg1cfYIKiKiaoDKfYLzZWF0mZxDw4cy4wkLmnwD8H5YoyJMAPNUCfyvAPyqfr4HebBtyXTT2JQRznE4mzEynvc+XccwTHRLWGNfPI8IaY48UvMbeBNc6wlU0zNvVcoUH+Xent/aNkUdFffAMzw5Sn3NY259wvowCutbyLnYkafacYaVvPArPJfDLLDzAQGlot3MxuitJs1eVLxcFVAfV8Fyv5ywa7xKvY/CLLHs5N0mzLxo8E4XFkPejDPyyn2V0VZL2/rSMpMJJNd65Q1X5BFKmiKPQZg650FTSkDeOwm0A1kr3WoKvRAiG3MO8ty90ZZkzOqRCIHutKgQyekmgVQgwW9KomsAyF0I1gV2UpJVlqgkkn6R5YFUTVERICxrVBKoJAMeQDtUEC6wJbOOawPljGXS2ZelbiSgtn+cFHObNjHuTtPfe8ppFhKV2UOA923aAvD/d6RetXoY6HD7U3UT0VwZi8bgm+6SaiWb9NATB0wy6M78FgFFwRERGLpB05JGLSAHzp2yRvaGI+pubpZrA1YbRNcybmQueNqNsts1XlTZBhNdNdbKPVUEgXxxxq3E6mIskr7kHU5x0e0ZimS/e38I5zCFR7lBV45ok9QTSNozz0OW0JM1s4XMpKQ14qRC4fIJY2otUhUD27lQIoEIgYRnVBHZqqSaw00U1gUS65oFVcwjWQns1h9xMY23DqD6Bm2BqDj0MzSFbZRlAP2amj5RZgQJ+ERhGU9tiXBMYxhCFfKR2y7uvuNbIHYpb4V+D+TiT1SgHOJh73l5ZNhmt+8MBZj5q7BH09Zzpn8rnA3CdiU8016ydl6TbjaqwOAo/BrARkQFolUVErI7xWHPt8wMaGEOrASpGWBk5LGD6Hig3codAbB3XNHZK4wU0wJz2KhzkuS0KNs+4puuYacpXEQfEr2SwIAfJ9k7tqzHRo4jxR757cUWHJjese/YM5Y83eIOImc38JtH0yvHmmpOJgk8bmyS6IOn0zPI3x9NMROENDFgY0nrDriTNHlO+Is0dmogabQaPmYTh9VOd/tby+fEo3EHAsZ4v5PYkzZ5Shp2IwrUMFHk/Qx1MtLbd6fWGQbJYfYeG2fOD3Sv9Y+zCp0JAKgQL2W3iwRh5mOsqBM01J4CCL5WJyETWohrVBEuqIe8wvH//vSoEKgQiRlJzyE0uNYfUHLJOtHexTEXdJkQC7AKuTBPYKss4yH813ekbPX3OPT18XG0PHVPe1EiAH9iqsFybP6+19jmDnG05L4b3vg+VZfa+Q0RPsTSvBYO/ScBPzb2SdZg3cdDIwYM58MQrCPxWwzQroj0gI8Vgb4QFRd6P1+FyjK19h5wY6Uf23lD8TIDXe21kFoiKIdmHGvDMb2SYI75cw7+t6xGOIfCFlmtXM9OHDPoi+P50d9sPffceR+HlABdVkHNfny+CpQZXVVdq6XNZJ9o3Vx85oNptFlzWyrK4VT8LTN7Nt1xCEEfh7QCO8HwGa2VZHDXWA2xMhffEeT9YTnyC7cMpwRNHa1cB+fWWey5J0sw7WdK1pqjvkGTjiwWrQjBbhKRCIGBAFQIBseYDVU1gp45qgooYTIJGNYFqAgm/FLCqCaQUc8CrJngYagJZt4mKOEmGxpo2IdUE0umVVaRNyB4TqGKivasNo2svzBCFSPdGWHBqGZ/LHIqj8G4Ajy7B35mk2dxu2rNf6moc40UZ0iF92UJ4FQJg3VSabfehmwoBoELg4BTVBHbCqCYAXH+MfT46DxWMagLVBKL/BKoJVBMsH+yu/dr3C6WaQDWBk1fUMbaT5kByjG9N0uxo369JVXCSNoxVrenCs5BCIE2bcO0xmKEjzt/a+4EPLaQ1xsRIprrZRBm3VAh89vZbmKUWHVIhqKCyzMUAKgQuLbO0QqQqBCoEqgnUHBq+xlg1gcQYWno/y1QTqCY44DXBLUmaFcUTcw5XUY1M3oH7Bvja+7b2it/pc444CndaCjbuTtLMKMBxrfmuKDw0YHpG+ToH+W3Tnf4d5fOTp4TPnBnQE8rnifgSAJaWK7i+PJaIiXa2O1mzjOOdrZc8ZiRfbraWIRxPyF9hPgM9HcATjb0DNxP4Z8Z55g8BtZ8/8Lyr5cpkq/HUAeeXWtYsWpM8y0LPqSTNzrO8I+swbwbeAKZiHNKco5KiGsZnGPRBky72opq4GU6D+MUGvGuYtyN3yKoJJqL6SQy6Ssr0Brx7or33kA63qSFryDveDLcQYdT3mWwJdK57xzfU11nnhzFdlHR7Rtdvae6QpCGvk16uohridtLpx+X79ufySumQDhUCB9eoEDQuo+FHuPp+c+aFk9YYqxA4WrOrJnCUV6omgGoC1QRqDtlCpOoTAGoOHTjmkDU65OxFKrTwcuJV1qaxguiQa1wT7230+0rTGbdPqplo1UeBwBYdsT7VVKc3aUSYzli9It8zYrRccZFFOjrJBW87zzlmbBN5iqjZCNEbLRGm4tlfbUR1HGkT8zjGlxCR0UyYmc8B5jYNFrKLG5x5Y9LtGw2PxeOa9tfokKshr5NiFY1rsuGfFLZckQ7piKOwKKhplNfOiY+0hX2te4zCYwfADl8GrCp3KI7CXQAO8V1XAlfZuCYVAgnZ7bAqBMA85ZUqBFa2qeA/gWqCWcZTTZBmxk808eA+1QSqCWwUUHMISz9EqppANcFC+wQHTHRIqgfiZmOcAozMuY95haPBrqwXqWOivWuY9+778GFbDpbtmaTRIYBvIAqMvqCuSNXgvvzi6a19IzoUR413EvlFhzjnI0A4w/udOKJDB4w55MyFWfhh3uz9koi2JZ3ey8rw0uiQ93r7AFiEiJlpi+DWh98c4/3VJ1AhELDtPKAqBO5C+wMmbULKSqKOfaoJRORdtGHeqglE76lo6qrmUJoZg0dkVLRDqxDs7Rr8kNcTSF+eCsHDcpi39csmqiwTVQ+hmsoy1zBvYLZKzKgsA3A7wEZlGWAf5u0SjuJrRXkwZ+A4BXwYGKnlnrsA/kb5PHHwpRz41/L5gPjlDF5p4HEM85YI8D5UlrnQfwvgH5cv1jDyhsl023fK5+Mo/AzAj5x7nu5K0uxVZdhzRhuHHFTDcw16OYZws2Nc04IO85YQfV9gJZpA2pXatR9mjLa72Sf2Zb+/vWesVT8iYCqmxngdBN40lfbfXAaWVpZ5LfYbIGnfIQnuWdgcK5PN2U0WIfDuSi1es6IbRNMrK1rTiUaFILyIGW8yvoSCXqQu4qoQuLlXhUA1QTXfNtUE1dBRNYFqgmo4SYZFNYFqAhnHuKAfhprgHoC/4k8dygGeEzGZ/17icu+evfC0ynKfte9QvCE8HgGMgePzrHspMxWjhuYcQcCvZuZnl8/XKHiNbUB5HIXbAF5WwrIc4BOMtQk3cU7vKJ8fGZn5r8krrv9e+fx4a+3TkfPh5fMzwb073tv5vNF3yP/9APEpjWOQ882We65jpinzPJ9KhNcK1vgqwL804a3vFEVukgXWykcMurptSZl27c3Vd6gW5KdOXnn9f5XvO+CHdMRRuNVWXlgDjptMM4Np4ijcDaAkBE5WsSbQCRirMtB4w5rjEARfLyN0zScoEgVBnFS2gSEQMfjidtp/vS8KHdLhoJRrXJMKgX1wnwqBr8g9NHALOq5JhUCFQM0hNYesI1xVEzw0X3jfVVQT+FJqHjj1CYBajqMnN2e3lsn0fyDGiwA5NbffAAAAAElFTkSuQmCC">
                        </div>
                    </div>
                @endif

                <div id="address-container">

                    @if($label->is_address_footer)
                        <div class="title">Prodotto e confezionato da:</div>
                        {!! $setting->address !!}
                    @endif

                    @if($label->barcode && trim($label->barcode != ""))
                        <div id="barcode">

                        </div>
                    @endif
                </div>
                <div id="weight-container">
                    <div class="small-border"></div>
                    <table>
                        <tr>
                            <td>Peso: <strong>{{ $label->weight }}</strong></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>Prod: <strong>{{ $label->production }}</strong></td>
                            <td>Scad: <strong>{{ $label->end_date }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endfor

</body>
</html>
