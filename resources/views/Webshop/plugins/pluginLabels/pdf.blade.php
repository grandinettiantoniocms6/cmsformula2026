<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    {{--Partendo da foglio A4--}}

    {{--Formato piccolo: widget 5.6cm  212px }}
    {{--Formato medio:   widget 7.7cm  291px }}
    {{--Formato grande:  widget 9.7cm  367px }}

    {{--Distanza tra etichette 0.5cm--  19px --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');

        <!--
        /* Roboto non si legge

        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

        */
        -->

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
            font-family: "Lato", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, Fira Sans, Droid Sans, Arial, sans-serif;
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
        #wrapper-mini .qr-code {
            margin: 0 55px;
            width: 50px;
            height: 50px;
        }
        #wrapper-mini .qr-code svg {
            width: 50px;
            height: 50px;
        }
        #wrapper-medium .qr-code {
            margin: 0 80px;
            width: 65px;
            height: 65px;
        }
        #wrapper-medium .qr-code svg {
            width: 65px;
            height: 65px;
        }
        #wrapper-large  .qr-code {
            margin: 0 100px;
            width: 80px;
            height: 80px;
        }
        #wrapper-large .qr-code svg {
            width: 80px;
            height: 80px;
        }

        #wrapper-mini .title-container h1 {
            font-size: 13.5px;
        }
        #wrapper-medium .title-container h1 {
            font-size: 17px;
        }
        #wrapper-large .title-container h1 {
            font-size: 21px;
        }

        #wrapper-mini .address-container {
            line-height: 16px;
            font-size: 10px;
        }
        #wrapper-mini .address-container .title {
            font-size: 12px;
        }

        #wrapper-medium .address-container {
            line-height: 19px;
            font-size: 16px;
        }
        #wrapper-medium .address-container .title {
            font-size: 16px;
        }

        #wrapper-large .address-container {
            line-height: 21px;
            font-size: 17px;
        }
        #wrapper-large .address-container .title {
            font-size: 17px;
        }

        #logo-container img {
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }
        .title-container {
            margin-bottom: 12px;
            line-height: 1.1;
            text-align: center;
            color: #7d5943;
            letter-spacing: -0.4px;
            padding: 0 20px;
        }
        #recipe-container {
            margin: 15px 0;
            text-align: center;
            color: #7d5943;
            padding: 0 5%;
        }
        #description-container {
            margin: 7px 0;
            text-align: center;
            color: #7d5943;
            padding: 0 10%;
        }
        #recipe-container h3 {
            font-size: 9px;
            line-height: 1.3;
            font-weight: 300;
        }
        #wrapper-mini #recipe-container {
            margin: 4px 0;
        }
        #wrapper-mini #recipe-container h3 {
            font-size: 9px;
            line-height: 1.3;
        }
        #description-container h2 {
            font-size: 9px;
            font-weight: 300;
            /*border-top: 1px solid #DEC7A4;
            border-bottom: 1px solid #DEC7A4;*/
            line-height: 1.1;
            padding-top: 0px;
            padding-bottom: 0px;
        }
        #wrapper-mini #description-container h2 {
            font-size: 9px;
        }
        #wrapper-mini #description-container {
            margin: 1px 0;
        }
        #produced-container {
            margin-top: 10px;
            margin-bottom: 15px;
            text-align: center;
            color: #7d5943;
            padding: 0 10%;
            font-size: 10px;
        }
        #produced-container p {
            margin-bottom: 9px;
        }
        #wrapper-mini #produced-container {
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: 8px;
        }
        .footer-container {
            margin-top: 8px;
            margin-bottom: 8px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            width: 100%;
        }
        .address-container {
            padding: 0 12px;
            color: #7d5943;
            line-height: 30px;
            font-size: 9px;
            font-weight: 300;
            text-align: center;
        }
        .address-container .title {
            margin-bottom: 1px;
            font-weight: 600;
            font-size: 9px;
        }
        #weight-container {
            margin: 1px 4% 0;
            color: #7d5943;
        }
        #weight-container .small-border {
            border-top: 1px solid #DEC7A4;
            margin: auto auto 4px;
        }
        #weight-container table {
            margin: 0;
            width: 100%;
            text-align: center;
            font-size: 16px;
            color: #7d5943;
            font-weight: 300;
        }
        #weight-container table td {
            padding: 4px;
        }
        #weight-container table td.left {
            padding-left: 0;
            text-align: right;
        }
        #weight-container table td.right {
            padding-right: 0;
            text-align: left;
        }
        #wrapper-mini #weight-container table {
            font-size: 13px;
            letter-spacing: -1px;
        }
        #wrapper-medium #weight-container table {
            font-size: 14px;
        }

        #tabella-nutrizionale {
            margin: 5px 0;
            padding: 0 10%;
        }
        #tabella-nutrizionale table {
            width: 100%;
            color: #7d5943;
            font-weight: 300;
            text-align: left;
            font-size: 15px;
        }
        #tabella-nutrizionale table th,
        #tabella-nutrizionale table td {
            padding: 2px;
            border: 1px solid #DEC7A4;
        }
        #tabella-nutrizionale table tr td:last-child {
            white-space: nowrap;
        }
        #wrapper-mini #tabella-nutrizionale {
            padding: 0 7%;
            margin: 5px 0;
        }
        #wrapper-mini #tabella-nutrizionale table {
            font-size: 8px;
        }

        .table-cell {
            display: table-cell;
            vertical-align: middle;
        }
        .label-container {
            display: table;
            width: 100%;
            border-left: 1.5mm solid #fff;
            border-right: 1.5mm solid #fff;
            /*height: 297mm;*/
            border-top: 2mm solid #fff;
            page-break-inside: avoid;
        }
        .label-wrapper {
            padding: 8px 0 10px;
            background-color: #F4E0B9;
            vertical-align: middle;
            font-family: "Lato", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", Ubuntu, Cantarell, "Helvetica Neue", Oxygen, Fira Sans, Droid Sans, Arial, sans-serif;
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
            margin: 5px 0 0;
            padding: 0 15px;
        }
        #barcode-wrapper {
            padding: 2px 5px;
            background-color: #fff;
            position: relative;
        }
        #barcode-number {
            position: absolute;
            bottom: 2px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            color: rgb(63,41,28);
            line-height: 1;
        }
        #barcode-number span {
            background-color: #fff;
            padding: 0 4px;
        }
        #barcode img {
            max-width: 100%;
            height: auto;
        }

        .label-row {
            text-align: center;
            margin: auto;
        }

        /* mini - medium - large */

        #wrapper-mini {
            width: 56mm;
        }
        #wrapper-medium {
            width: 77mm;
        }
        #wrapper-large {
            width: 97mm;
        }

        table.table {
            width: 100%;
            margin: 0 auto 0;
            padding: 0;
        }
        table.table#table-mini {
            width: 183mm; /* 56+3 * 3*/
        }
        table.table#table-medium {
            width: 166mm; /* 77+3 * 2*/
        }
        table.table#table-large {
            width: 206mm;  /* 97+3 * 2*/
        }
</style>

<title>Pasticceria Righetto - Etichette</title>
</head>
<body>

<?php
    $max = $label->number_elements;

    if ( $label->format == 'mini' ) {
        $cells_x_rows = 3;
    } else {
        $cells_x_rows = 2;
    }
?>


    @for ($i = 1; $i <= $max; $i++)
        @if ( $i % $cells_x_rows == 1)<table class="table" id="table-{{ $label->format }}"><tr>@endif
            <td>
                @include("Webshop.plugins.pluginLabels.inc.etichetta")
            </td>
        @if ( $i == $max || $i % $cells_x_rows == 0)</tr></table>@endif
    @endfor

</body>
</html>
