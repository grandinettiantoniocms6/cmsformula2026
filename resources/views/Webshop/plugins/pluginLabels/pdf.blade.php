<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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

        #wrapper-mini {
            width: 710px;
        }

        #wrapper-medium {
            width: 950px;
        }

        #wrapper-large {
            width: 1180px;
        }

        #wrapper-mini .qr-code {
            margin: 0 180px;
            width: 190px;
            height: 190px;
        }
        #wrapper-mini .qr-code img {
            width: 190px;
            height: 190px;
        }
        #wrapper-medium .qr-code {
            margin: 0 275px;
            width: 200px;
            height: 200px;
        }
        #wrapper-medium .qr-code img {
            width: 200px;
            height: 200px;
        }
        #wrapper-large  .qr-code {
            margin: 0 350px;
            width: 250px;
            height: 250px;
        }
        #wrapper-large .qr-code img {
            width: 250px;
            height: 250px;
        }

        #wrapper-mini .title-container h1 {
            font-size: 38px;
        }
        #wrapper-medium .title-container h1 {
            font-size: 54px;
        }
        #wrapper-large .title-container h1 {
            font-size: 60px;
        }

        #wrapper-mini .address-container {
            line-height: 30px;
            font-size: 22px;
        }
        #wrapper-mini .address-container .title {
            font-size: 22px;
        }

        #wrapper-medium .address-container {
            line-height: 34px;
            font-size: 26px;
        }
        #wrapper-medium .address-container .title {
            font-size: 26px;
        }

        #wrapper-large .address-container {
            line-height: 38px;
            font-size: 30px;
        }
        #wrapper-large .address-container .title {
            font-size: 30px;
        }

        #logo-container img {
            display: block;
            margin-bottom: 35px;
            width: 100%;
        }
        .title-container {
            margin-bottom: 20px;
            text-align: center;
            color: #7d5943;
            letter-spacing: -0.4px;
            padding: 0 25px;
        }
        .title-container h1 {
            font-size: 38px;
        }
        #recipe-container {
            margin: 20px 0;
            text-align: center;
            color: #7d5943;
            padding: 0 5%;
        }
        #description-container {
            margin: 20px 0;
            text-align: center;
            color: #7d5943;
            padding: 0 10%;
        }
        #recipe-container h3 {
            font-size: 28px;
            line-height: 36px;
            font-weight: 300;
        }
        #description-container h2 {
            font-size: 30px;
            font-weight: 300;
            border-top: 1px solid #DEC7A4;
            border-bottom: 1px solid #DEC7A4;
            line-height: 1.1;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        #produced-container {
            margin-top: 50px;
            margin-bottom: 35px;
            text-align: center;
            color: #7d5943;
            padding: 0 70px;
            font-size: 26px;
            font-weight: bold;
        }
        #produced-container p {
            margin-bottom: 10px;
        }
        .footer-container {
            margin-top: 35px;
            margin-bottom: 35px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            width: 100%;
        }
        .address-container {
            padding: 0 15px;
            color: #7d5943;
            line-height: 30px;
            font-size: 22px;
            font-weight: 300;
            text-align: center;
        }
        .address-container .title {
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
            padding: 0 10%;
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
            height: 49.8%;
            background-color: #fff;
            border: 0px solid #fff;
            float: left;
            vertical-align: middle;
            text-align: center;
        }
        .label-wrapper {
            padding: 35px 0;
            background-color: #F4E0B9;
            margin: auto;
            font-family: "Roboto", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, Fira Sans, Droid Sans, Arial, sans-serif;
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

        #barcode {
            text-align: center;
            margin: 35px 0;
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
    @include("Webshop.plugins.pluginLabels.inc.etichetta")
    <div class="clearfix"></div>
@endfor

</body>
</html>
