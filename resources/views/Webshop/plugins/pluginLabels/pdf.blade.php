<html>
<head>
    <style>
        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol, ul {
            list-style: none;
        }

        blockquote, q {
            quotes: none;
        }

        blockquote:before, blockquote:after, q:before, q:after {
            content: '';
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        input:focus, button:focus, .button:focus, select:focus, textarea:focus, textarea:focus, button:focus {
            outline: 0 !important;
        }

        h1 {
            font-size: 3em;
            margin: 15px 0;
        }

        .full-width {
            width: 100% !important;
        }

        .center {
            text-align: center;
        }

        .col-desc {
            font-weight: bold;
            text-align: right;
        }

        input, button, .button, input[type="submit"], select, textarea {
            width: 100%;
            border: 2px solid #eac377;
            border-radius: 0.25em;
            background-color: white;
            font-size: 16px;
            color: #555;
            padding: 0.6em;
            outline: 0;
        }
        input:disabled, button:disabled, .button:disabled, select:disabled, textarea:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            border-color: #aaa;
            color: #aaa;
        }
        input:disabled + label, button:disabled + label, .button:disabled + label, select:disabled + label, textarea:disabled + label {
            opacity: 0.6;
        }

        input[type="checkbox"], input[type="radio"], button[type="radio"], [type="radio"].button, select[type="radio"], textarea[type="radio"], button[type="checkbox"], [type="checkbox"].button, select[type="checkbox"], textarea[type="checkbox"] {
            -webkit-appearance: none;
            appearance: none;
            width: 0.8em;
            height: 0.8em;
            line-height: 100;
            margin: 0 0.5em;
            padding: 0.30em;
            display: inline-block;
            position: relative;
            cursor: pointer;
            background-color: white;
        }
        input[type="checkbox"]:checked, input[type="radio"]:checked, button[type="radio"]:checked, [type="radio"].button:checked, select[type="radio"]:checked, textarea[type="radio"]:checked, button[type="checkbox"]:checked, [type="checkbox"].button:checked, select[type="checkbox"]:checked, textarea[type="checkbox"]:checked {
            background-color: #eac377;
        }
        input[type="checkbox"] + label, input[type="radio"] + label, button[type="radio"] + label, [type="radio"].button + label, select[type="radio"] + label, textarea[type="radio"] + label, button[type="checkbox"] + label, [type="checkbox"].button + label, select[type="checkbox"] + label, textarea[type="checkbox"] + label {
            cursor: pointer;
            margin-right: 1em;
            display: inline-block;
            padding: 0.15em 0;
        }
        input[type="checkbox"].big, input.big[type="radio"], button.big[type="radio"], .big[type="radio"].button, select.big[type="radio"], textarea.big[type="radio"], button[type="checkbox"].big, [type="checkbox"].big.button, select[type="checkbox"].big, textarea[type="checkbox"].big {
            font-size: 32px;
            margin-left: 0;
        }
        input[type="checkbox"].big + label, input.big[type="radio"] + label, button.big[type="radio"] + label, .big[type="radio"].button + label, select.big[type="radio"] + label, textarea.big[type="radio"] + label, button[type="checkbox"].big + label, [type="checkbox"].big.button + label, select[type="checkbox"].big + label, textarea[type="checkbox"].big + label {
            font-size: 32px;
        }

        input[type="radio"], button[type="radio"], [type="radio"].button, select[type="radio"], textarea[type="radio"] {
            border-radius: 100%;
        }

        button, .button, input[type="submit"], button[type="submit"], [type="submit"].button, select[type="submit"], textarea[type="submit"] {
            width: auto;
            background-color: transparent;
            color: #eac377;
            text-decoration: none;
            transition: 0.2s ease;
            cursor: pointer;
        }
        button:not([disabled]):hover, .button:not([disabled]):hover, input[type="submit"]:not([disabled]):hover, button[type="submit"]:not([disabled]):hover, [type="submit"].button:not([disabled]):hover, select[type="submit"]:not([disabled]):hover, textarea[type="submit"]:not([disabled]):hover {
            background-color: #eac377;
            color: white;
        }
        button.menu-button, .button.menu-button, input[type="submit"].menu-button, button[type="submit"].menu-button, [type="submit"].menu-button.button, select[type="submit"].menu-button, textarea[type="submit"].menu-button {
            color: #fcf9f1;
            border-color: #fcf9f1;
            width: 2.5em;
            height: 2.5em;
            padding: 0.5em;
            float: right;
        }
        button.active, .button.active, input[type="submit"].active, button[type="submit"].active, [type="submit"].active.button, select[type="submit"].active, textarea[type="submit"].active {
            background-color: #eac377;
            color: #fcf9f1;
        }

        textarea {
            min-height: 6em;
            resize: vertical;
        }

        @font-face {
            font-family: "font declaration here because phantomjs has a bug that prevent to use the first declared font";
        }
        @font-face {
            font-family: 'Comfortaa-Regular FontFace';
            src: url("../fonts/comfortaa-regular-webfont.ttf");
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'DBJ Holly Berry Wonderland FontFace';
            src: url("../fonts/djb_holly_berry_wonderland-webfont.ttf");
        }
        @font-face {
            font-family: 'Roboto Regular FontFace';
            src: url("../fonts/roboto-regular-webfont.eot");
            src: url("../fonts/roboto-regular-webfont.eot?#iefix") format("embedded-opentype"), url("../fonts/roboto-regular-webfont.woff2") format("woff2"), url("../fonts/roboto-regular-webfont.woff") format("woff"), url("../fonts/roboto-regular-webfont.ttf") format("truetype"), url("../fonts/roboto-regular-webfont.svg#robotoregular") format("svg");
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Roboto Light FontFace';
            src: url("../fonts/Roboto-Light.eot");
            src: url("../fonts/Roboto-Light.eot?#iefix") format("embedded-opentype"), url("../fonts/Roboto-Light.woff2") format("woff2"), url("../fonts/Roboto-Light.woff") format("woff"), url("../fonts/Roboto-Light.ttf") format("truetype"), url("../fonts/Roboto-Light.svg#robotoregular") format("svg");
            font-weight: 300;
            font-style: normal;
        }
        @font-face {
            font-family: 'Roboto Light FontFace';
            src: url("../fonts/Roboto-Bold.eot");
            src: url("../fonts/Roboto-Bold.eot?#iefix") format("embedded-opentype"), url("../fonts/Roboto-Bold.woff2") format("woff2"), url("../fonts/Roboto-Bold.woff") format("woff"), url("../fonts/Roboto-Bold.ttf") format("truetype"), url("../fonts/Roboto-Bold.svg#robotoregular") format("svg");
            font-weight: 700;
            font-style: normal;
        }
        @font-face {
            font-family: 'Roboto Light FontFace';
            src: url("../fonts/Roboto-Medium.eot");
            src: url("../fonts/Roboto-Medium.eot?#iefix") format("embedded-opentype"), url("../fonts/Roboto-Medium.woff2") format("woff2"), url("../fonts/Roboto-Medium.woff") format("woff"), url("../fonts/Roboto-Medium.ttf") format("truetype"), url("../fonts/Roboto-Medium.svg#robotoregular") format("svg");
            font-weight: 600;
            font-style: normal;
        }
        @font-face {
            font-family: 'Roboto Bold FontFace';
            src: url("../fonts/Roboto-Medium.eot");
            src: url("../fonts/Roboto-Medium.eot?#iefix") format("embedded-opentype"), url("../fonts/Roboto-Medium.woff2") format("woff2"), url("../fonts/Roboto-Medium.woff") format("woff"), url("../fonts/Roboto-Medium.ttf") format("truetype"), url("../fonts/Roboto-Medium.svg#robotoregular") format("svg");
            font-weight: 600;
            font-style: normal;
        }
        @font-face {
            font-family: 'Droid Sans FontFace';
            src: url("../fonts/DroidSans.eot");
            src: url("../fonts/DroidSans.eot?#iefix") format("embedded-opentype"), url("../fonts/DroidSans.woff2") format("woff2"), url("../fonts/DroidSans.woff") format("woff"), url("../fonts/DroidSans.ttf") format("truetype"), url("../fonts/DroidSans.svg#robotoregular") format("svg");
            font-weight: 300;
            font-style: normal;
        }
        @font-face {
            font-family: 'Droid Sans FontFace';
            src: url("../fonts/DroidSans-Bold.eot");
            src: url("../fonts/DroidSans-Bold.eot?#iefix") format("embedded-opentype"), url("../fonts/DroidSans-Bold.woff2") format("woff2"), url("../fonts/DroidSans-Bold.woff") format("woff"), url("../fonts/DroidSans-Bold.ttf") format("truetype"), url("../fonts/DroidSans-Bold.svg#robotoregular") format("svg");
            font-weight: 600;
            font-style: normal;
        }
        @font-face {
            font-family: 'Courier New Regular FontFace';
            src: url("../fonts/courier_new-webfont.eot");
            src: url("../fonts/courier_new-webfont.eot?#iefix") format("embedded-opentype"), url("../fonts/courier_new-webfont.woff2") format("woff2"), url("../fonts/courier_new-webfont.woff") format("woff"), url("../fonts/courier_new-webfont.ttf") format("truetype"), url("../fonts/courier_new-webfont.svg#courier_newregular") format("svg");
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Georgia FontFace';
            src: url("../fonts/Georgia.eot");
            src: url("../fonts/Georgia.eot?#iefix") format("embedded-opentype"), url("../fonts/Georgia.woff") format("woff"), url("../fonts/Georgia.ttf") format("truetype"), url("../fonts/Georgia.svg#courier_newregular") format("svg");
            font-weight: normal;
            font-style: normal;
        }
        .ng-hide-add {
            /*animation: 0.5s toggleOut ease;*/
            animate: 0.5s closeHeight ease;
        }

        .ng-hide-remove {
            /*animation: 0.5s toggleIn ease;*/
            animate: openHeight 0.5s linear;
        }

        @-webkit-keyframes closeHeight {
            0% {
                -webkit-transform: scaleY(1);
                transform: scaleY(1);
            }
            100% {
                -webkit-transform: scaleY(0);
                transform: scaleY(0);
            }
        }

        @keyframes closeHeight {
            0% {
                -webkit-transform: scaleY(1);
                transform: scaleY(1);
            }
            100% {
                -webkit-transform: scaleY(0);
                transform: scaleY(0);
            }
        }
        * {
            box-sizing: border-box;
        }

        .rect-background {
            background-color: #F4E0B9;
        }

        #header {
            display: none;
        }

        #title-container {
            display: none;
            width: 90%;
            margin-left: 5%;
            text-align: center;
            color: #7d5943;
            letter-spacing: -0.4px;
        }
        #title-container h1 {
            font-family: 'DBJ Holly Berry Wonderland, DBJ Holly Berry Wonderland FontFace';
            line-height: 1.5;
        }

        #description-container {
            display: none;
            text-align: center;
            color: #7d5943;
            width: 80%;
            margin-left: 10%;
        }
        #description-container h2 {
            line-height: 1.1;
            padding-top: 15px;
            padding-bottom: 15px;
            border-top: 1px solid #DEC7A4;
            border-bottom: 1px solid #DEC7A4;
            margin-left: auto;
            margin-right: auto;
        }

        #produced-container {
            display: none;
            text-align: center;
            color: #7d5943;
            width: 80%;
            margin-left: 10%;
        }
        #produced-container h2 {
            line-height: 1.1;
        }
        #produced-container p {
            margin-bottom: 10px;
        }

        #recipe-container {
            display: none;
            text-align: center;
            width: 90%;
            margin-left: 5%;
            color: #7d5943;
        }
        #recipe-container b {
            font-weight: 600;
        }
        #recipe-container i {
            font-style: italic;
        }

        table {
            display: none;
            width: 80%;
            margin-left: 10%;
        }
        table td {
            border: 1px solid #7d5943;
            border: 1px solid #A88A6E;
            border: 1px solid #DEC7A4;
            padding: 3px;
            color: #7d5943;
            padding-left: 5px;
            font-family: 'Roboto Light, Roboto Light FontFace';
        }

        #footer-container {
            display: none;
            width: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }
        #footer-container #qr {
            height: 100%;
        }

        #weight-block-container {
            display: none;
            text-align: center;
            color: #7d5943;
            font-family: 'Roboto Regular, Roboto Regular FontFace';
            letter-spacing: -1px;
            font-weight: 600;
            width: 90%;
            margin-left: 5%;
        }
        #weight-block-container .small-border {
            border-top: 1px solid #DEC7A4;
            margin: auto;
            margin-bottom: 15px;
            width: 90%;
        }
        #weight-block-container .label {
            font-weight: 400;
            font-family: 'Roboto Light, Roboto Light FontFace';
            margin-right: 10px;
        }
        #weight-block-container h2 {
            display: inline-block;
        }
        #weight-block-container #weight-container {
            display: block;
        }
        #weight-block-container #dateprod-container {
            display: inline-block;
            margin-right: 10px;
            margin-top: 10px;
        }
        #weight-block-container #dateprod-container h2 {
            margin-right: 10px;
        }
        #weight-block-container #dateexp-container {
            display: inline-block;
        }
        #weight-block-container h2 {
            line-height: 1.1;
        }

        #address-bar-container {
            width: 90%;
            margin-left: 5%;
            color: #7d5943;
        }
        #address-bar-container #address {
            display: inline-block;
            width: 60%;
            overflow: hidden;
            padding-right: 5px;
            vertical-align: top;
            margin-left: auto;
            margin-right: auto;
        }
        #address-bar-container #address a {
            text-decoration: none;
            color: #7d5943;
        }
        #address-bar-container #address p.title {
            margin-bottom: 5px;
        }
        #address-bar-container #address p {
            line-height: 19px;
        }
        #address-bar-container #bar {
            display: inline-block;
            width: 40%;
            overflow: hidden;
            padding-left: 5px;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }
        #address-bar-container #bar img {
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 100%;
        }
    </style>
    <title>Pasticceria Righetto - gestione etichette</title>
</head>
<body>
<div class="rect-background" style="width: 709px; padding-bottom: 35px; margin: auto;">
    @if($setting->logo && $label->is_logo_header)
       <img id="header" src="{{ url($setting->logo) }}" style="display: inline; margin-top: 35px; margin-bottom: 35px; width: 100%;">
    @endif

    @if($label->title && trim($label->title != ""))
        <div id="title-container" style="display: block; margin-top: 8.92396px; margin-bottom: 22.3099px;">
            <h1 id="title" style="font-size: 38.2456px; font-family: &quot;DBJ Holly Berry Wonderland&quot;, &quot;DBJ Holly Berry Wonderland FontFace&quot;;">
                {{ $label->title }}
            </h1>
        </div>
    @endif

    @if($label->ingredients && trim($label->ingredients != ""))
        <div id="recipe-container" style="display: block; margin-top: 22.3099px; margin-bottom: 22.3099px;">
            <h3 id="recipe" style="font-size: 17.8479px; font-family: &quot;Roboto Light&quot;; line-height: 22.3099px; font-weight: 400;">
                {!! $label->ingredients !!}
            </h3>
        </div>
    @endif

    @if($label->description && trim($label->description != ""))
        <div id="description-container" style="display: block; margin-top: 22.3099px; margin-bottom: 22.3099px;">
            <h2 id="description" style="font-size: 31.8713px; font-family: &quot;Roboto Light&quot;; font-weight: 400;">
                {!! $label->description !!}
            </h2>
        </div>
    @endif

    @if($label->is_product_lab)
        <div id="produced-container" style="display: block; margin-top: 49px; margin-bottom: 35px;">
            <h2 id="produced" style="font-size: 26px; font-family: &quot;Roboto Regular&quot;; font-weight: bold;">
                <p>Prodotto in laboratorio che usa anche nocciole, frutta con guscio, latte, uova</p>
            </h2>
        </div>
    @endif

    @if($label->is_product_lab)
        {!! $label->table_nutr !!}
    @endif

    @if($label->qrcode_link && trim($label->qrcode_link != ""))
        <div id="footer-container"
             style="display: block; @if($setting->photo) background-image: url({{ url($setting->photo) }}); @endif height: 193px; margin-top: 35px; margin-bottom: 35px;">
            <div id="qr" style="margin-left: 24%;"><img
                    src="data:image/png;base64,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">
            </div>
        </div>
    @endif
    <div id="address-bar-container">

        @if($label->is_address_footer)
            <div id="address"
                 style="font-size: 22px; font-family: &quot;Roboto Light&quot;; font-weight: 400; display: block; text-align: center;">
                <p class="title"
                   style="font-size: 22px; font-family: &quot;Roboto Regular&quot;; font-weight: 600; line-height: 30px;">
                    Prodotto e confezionato da:
                </p>

                 {!! $setting->address !!}
            </div>
        @endif

        @if($label->barcode && trim($label->barcode != ""))
             <div id="bar" style="display: none;"><img></div>
        @endif
    </div>
    <div id="weight-block-container" style="display: block; margin-top: 35px; margin-bottom: 0px;">
        <div class="small-border"></div>
        <div id="weight-container" class="col-12"><h2 id="weight-label" class="label" style="font-size: 32px;">
                Peso:</h2>
            <h2 id="weight" style="font-size: 32px;">{{ $label->weight }}</h2></div>
        <div id="dateprod-container" class="col-6"><h2 id="dateprod-label" class="label" style="font-size: 32px;">
                Prod:</h2>
            <h2 id="dateprod" style="font-size: 32px;">{{ $label->production }}</h2></div>
        <div id="dateexp-container" class="col-6"><h2 id="dateexp-label" class="label" style="font-size: 32px;">
                Scad:</h2>
            <h2 id="dateexp" style="font-size: 32px;">{{ $label->end_date }}</h2></div>
    </div>
</div>
</body>
</html>
