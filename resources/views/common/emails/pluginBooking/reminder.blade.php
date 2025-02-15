<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,500,500i,600,700,800,900">
    <style type="text/css">
        p{
            font-family: "Roboto", sans-serif;
            margin:10px 0;
            padding:0;
        }
        table{
            border-collapse:collapse;
        }
        table.order tr td, table.order tr th{
            padding: 8px 0;
        }
        h1,h2,h3,h4,h5,h6{
            font-family: "Roboto", sans-serif;
            display:block;
            margin:0;
            padding:0;
        }
        img,a img{
            border:0;
            height:auto;
            outline:none;
            text-decoration:none;
        }
        body,#bodyTable,#bodyCell{
            font-family: "Roboto", sans-serif;
            height:100%;
            margin:0;
            padding:0;
            width:100%;
        }
        .mcnPreviewText{
            display:none !important;
        }
        #outlook a{
            padding:0;
        }
        img{
            -ms-interpolation-mode:bicubic;
        }
        table{
            mso-table-lspace:0pt;
            mso-table-rspace:0pt;
        }
        .ReadMsgBody{
            width:100%;
        }
        .ExternalClass{
            width:100%;
        }
        p,a,li,td,blockquote{
            mso-line-height-rule:exactly;
        }
        a[href^=tel],a[href^=sms]{
            color:inherit;
            cursor:default;
            text-decoration:none;
        }
        p,a,li,td,body,table,blockquote{
            -ms-text-size-adjust:100%;
            -webkit-text-size-adjust:100%;
        }
        .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
            line-height:100%;
        }
        a[x-apple-data-detectors]{
            font-family: "Roboto", sans-serif;
            color:inherit !important;
            text-decoration:none !important;
            font-size:inherit !important;
            font-family:inherit !important;
            font-weight:inherit !important;
            line-height:inherit !important;
        }
        .templateContainer{
            max-width:100% !important;
        }
        a.mcnButton{
            display:block;
        }
        .mcnImage,.mcnRetinaImage{
            vertical-align:bottom;
        }
        .mcnTextContent{
            word-break:break-word;
        }
        .mcnTextContent img{
            height:auto !important;
        }
        .mcnDividerBlock{
            table-layout:fixed !important;
        }

        h1{
            /*@editable*/color:#222222;
            /*@editable*/font-family: "Roboto", sans-serif;
            /*@editable*/font-size:28px;
            /*@editable*/font-style:normal;
            /*@editable*/font-weight:bold;
            /*@editable*/line-height:150%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:left;
        }

        h2{
            /*@editable*/color:#222222;
            /*@editable*/font-family: "Roboto", sans-serif;
            /*@editable*/font-size:28px;
            /*@editable*/font-style:normal;
            /*@editable*/font-weight:bold;
            /*@editable*/line-height:150%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:left;
        }


        h3{
            /*@editable*/color:#444444;
            /*@editable*/font-family: "Roboto", sans-serif;
            /*@editable*/font-size:22px;
            /*@editable*/font-style:normal;
            /*@editable*/font-weight:bold;
            /*@editable*/line-height:150%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:left;
        }

        h4{
            /*@editable*/color:#999999;
            /*@editable*/font-family: "Roboto", sans-serif;
            /*@editable*/font-size:20px;
            /*@editable*/font-style:italic;
            /*@editable*/font-weight:normal;
            /*@editable*/line-height:125%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:left;
        }

        #templateHeader{
            /*@editable*/background-color:#FFFFFF;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:20px;
            /*@editable*/padding-bottom:20px;
        }

        .headerContainer{
            /*@editable*/background-color:transparent;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:0;
            /*@editable*/padding-bottom:0;
        }

        .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
            /*@editable*/color:#808080;
            /*@editable*/font-family: "Roboto", sans-serif;
            /*@editable*/font-size:16px;
            /*@editable*/line-height:150%;
            /*@editable*/text-align:left;
        }

        .headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{
            /*@editable*/color:#ff433c;
            /*@editable*/font-weight:normal;
            /*@editable*/text-decoration:underline;
        }

        #templateBody{
            /*@editable*/background-color:#FFFFFF;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:0px;
            /*@editable*/padding-bottom:40px;
        }

        .bodyContainer{
            /*@editable*/background-color:transparent;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:0;
            /*@editable*/padding-bottom:0;
        }

        .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
            /*@editable*/color:#808080;
            /*@editable*/font-family: "Roboto", sans-serif;
            /*@editable*/font-size:16px;
            /*@editable*/line-height:150%;
            /*@editable*/text-align:left;
        }

        .bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{
            /*@editable*/color:#ff433c;
            /*@editable*/font-weight:normal;
            /*@editable*/text-decoration:underline;
        }

        #templateFooter{
            /*@editable*/background-color:#000;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:35px;
            /*@editable*/padding-bottom:33px;
        }

        .footerContainer{
            /*@editable*/background-color:transparent;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:0;
            /*@editable*/padding-bottom:0;
        }

        .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
            /*@editable*/color:#ffffff;
            /*@editable*//*font-family:Helvetica;*/
            font-family: "Roboto", sans-serif;
            /*@editable*/font-size:12px;
            /*@editable*/line-height:150%;
            /*@editable*/text-align:center;
        }

        .footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{
            /*@editable*/color:#ffffff;
            /*@editable*/font-weight:normal;
            /*@editable*/text-decoration:underline;
        }
        @media only screen and (min-width:768px){
            .templateContainer{
                width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            body,table,td,p,a,li,blockquote{
                -webkit-text-size-adjust:none !important;
            }

        }	@media only screen and (max-width: 480px){
            body{
                width:100% !important;
                min-width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnRetinaImage{
                max-width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImage{
                width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
                max-width:100% !important;
                width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnBoxedTextContentContainer{
                min-width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageGroupContent{
                padding:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
                padding-top:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
                padding-top:18px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageCardBottomImageContent{
                padding-bottom:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageGroupBlockInner{
                padding-top:0 !important;
                padding-bottom:0 !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageGroupBlockOuter{
                padding-top:9px !important;
                padding-bottom:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnTextContent,.mcnBoxedTextContentColumn{
                padding-right:18px !important;
                padding-left:18px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
                padding-right:18px !important;
                padding-bottom:0 !important;
                padding-left:18px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcpreview-image-uploader{
                display:none !important;
                width:100% !important;
            }

        }	@media only screen and (max-width: 480px){

            h1{
                /*@editable*/font-size:30px !important;
                /*@editable*/line-height:125% !important;
            }

        }	@media only screen and (max-width: 480px){

            h2{
                /*@editable*/font-size:26px !important;
                /*@editable*/line-height:125% !important;
            }

        }	@media only screen and (max-width: 480px){

            h3{
                /*@editable*/font-size:20px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){

            h4{
                /*@editable*/font-size:18px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){

            .mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
                /*@editable*/font-size:14px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){

            .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
                /*@editable*/font-size:16px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){

            .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
                /*@editable*/font-size:16px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){

            .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
                /*@editable*/font-size:14px !important;
                /*@editable*/line-height:150% !important;
            }

        }</style></head>
<body>

<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <!-- BEGIN TEMPLATE // -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <!-- HEADER // -->
                    <tr>
                        <td align="center" valign="top" id="templateHeader" data-template-container>
                            <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:100%;">
                                <tr>
                                    <td align="center" valign="top" width="600" style="width:100%;">
                            <![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="headerContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
                                            <tbody class="mcnImageBlockOuter">
                                            <tr>
                                                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                                                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                                                        <tbody>
                                                        <tr>
                                                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:left;">
                                                                <?php
                                                                $theme = env('THEME');
                                                                $website = \App\Models\WebsiteSetting::first();
                                                                ?>
                                                                @if(@$website->logo_email == "logo1")
                                                                    @if($website->logo)
                                                                        <img style="max-width: 220px;" src="{{ url($website->logo) }}" alt="{{ env('PROJECT_NAME') }}" title="{{ env('PROJECT_NAME') }}">
                                                                    @endif
                                                                @endif

                                                                @if($website->logo_email == "logo2")
                                                                    @if($website->logo2)
                                                                        <img style="max-width: 220px;" src="{{ url($website->logo2) }}" alt="{{ env('PROJECT_NAME') }}" title="{{ env('PROJECT_NAME') }}">
                                                                    @endif
                                                                @endif

                                                                @if($website->logo_email == "logo3")
                                                                    @if($website->logo3)
                                                                        <img style="max-width: 220px;" src="{{ url($website->logo3) }}" alt="{{ env('PROJECT_NAME') }}" title="{{ env('PROJECT_NAME') }}">
                                                                    @endif
                                                                @endif
                                                                <span style="display: none">{{ config('app.name') }}</span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                    <!-- CONTENT // -->
                    <tr>
                        <td align="center" valign="top" id="templateBody" data-template-container>
                            <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:100%;">
                                <tr>
                                    <td align="center" valign="top" width="600" style="width:100%;">
                            <![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="bodyContainer">
                                        <!--Contenuto-->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                    <!--[if mso]>
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                        <tr>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    <td valign="top" width="600" style="width:100%;">
                                                    <![endif]-->
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                <p style="text-align: left!important; font-size:18px !important;">{{ @$labels['booking-myarea-email-ciao'] }} {{ $data['user']->name }},
                                                                <br><br>

                                                                    <?php
                                                                    $reservation = $data['reservation'];
                                                                    $type = \App\Models\PluginBookingType::find($reservation->type_id);
                                                                    ?>

                                                                    <!-- qui esce il messaggio pilotato da Admin -->
                                                                    {!! $type->description_reminder !!}
                                                                    <!-- / messaggio admin -->
                                                                    <br><br>
                                                                    <h4 class="mb-4">{{ @$labels['booking-riassume-title'] }}</h4>

                                                                    <table class="table table-sm font-sm" width="100%">
                                                                        <tbody>
                                                                        <tr>
                                                                            <th>{{ @$labels['booking-riassume-dal'] }}</th>
                                                                            <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_start)->format("d/m/Y") }}
                                                                                @if($reservation->start_time)
                                                                                    {{ @$labels['booking-myarea-ore'] }} {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->start_time)->format("H:i") }}

                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        @if($reservation->date_end)
                                                                            <tr>
                                                                                <th>{{ @$labels['booking-riassume-al'] }}</th>
                                                                                <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_end)->format("d/m/Y") }}
                                                                                    @if($reservation->end_time)
                                                                                        {{ @$labels['booking-myarea-ore'] }} {{ \Carbon\Carbon::createFromFormat("H:i:s", $reservation->end_time)->format("H:i") }}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>

                                                                            @if($reservation->date_end && $reservation->date_start)
                                                                                <tr>
                                                                                    <th>{{ @$labels['booking-myarea-ordine-notti'] }}</th>
                                                                                    <td>
                                                                                        <?php
                                                                                        $diff = \Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_start)->diffInDays(\Carbon\Carbon::createFromFormat("Y-m-d", $reservation->date_end));
                                                                                        if($diff == 0){
                                                                                            $diff = 1;
                                                                                        }
                                                                                        echo $diff;
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endif
                                                                    <tr>
                                                                        <th>{{ $type->label_checkout }}</th>
                                                                        <td>
                                                                            <?php
                                                                            $reservation_room = \App\Models\PluginBookingReservationRoom::where("plugin_booking_reservation_id", $reservation->id)->first();
                                                                            $room = \App\Models\PluginBookingRoom::find($reservation_room->plugin_booking_room_id); ?>
                                                                            @if($room)
                                                                            {{ $room->name }}
                                                                            <?php
                                                                            $price = number_format($reservation_room->price,2,",",".");
                                                                            ?>
                                                                            &euro; {{ $price }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>{{ @$labels['booking-myarea-numero-ospiti'] }}</th>
                                                                        <td>
                                                                            @if($type->is_checkin)
                                                                                <?php
                                                                                $reservation_partecipants = \App\Models\PluginBookingReservationRoomCheckin::where("plugin_booking_reservation_room_id", $reservation_room->id)->get();
                                                                                ?>
                                                                                @if($reservation_partecipants)
                                                                                    <ul class="style-1">
                                                                                        @foreach($reservation_partecipants as $partecipant)
                                                                                            <li>{{ $partecipant->first_name }} {{ $partecipant->last_name }} {{ @$labels['booking-myarea-email-nato-il'] }} {{ \Carbon\Carbon::createFromFormat("Y-m-d", $partecipant->birthdate)->format("d/m/Y") }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            @else
                                                                                {{ $reservation->total_qty }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $reservation_services = \App\Models\PluginBookingReservationService::where("plugin_booking_reservation_id", $reservation_room->id)->get();
                                                                    ?>

                                                                    @if(count($reservation_services))
                                                                        <tr>
                                                                            <th>{{ @$labels['booking-riassume-servizi'] }}</th>
                                                                            <td>
                                                                                <ul class="style-1">
                                                                                    @foreach($reservation_services as $servizio)
                                                                                        <?php
                                                                                        $label = $labels['booking-riassume-giorno'];
                                                                                        if($servizio->days > 1){
                                                                                            $tot_serv = ($servizio->price * $servizio->days);
                                                                                            $tot_serv = number_format($tot_serv,2,",", ".");
                                                                                            $label = $labels['booking-riassume-giorni'];

                                                                                            $label_price = "x $servizio->days $label = € $tot_serv";
                                                                                        }else{
                                                                                            $label_price = "";
                                                                                        }
                                                                                        ?>
                                                                                        <li>{{ $servizio->name }} (&euro; {!! number_format($servizio->price,2,",", ".") !!}) {{ $label_price }} </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    </tbody>
                                                                    @if($reservation->total > 0)
                                                                        <tfoot>
                                                                        <th>{{ @$labels['booking-riassume-totale'] }}</th>
                                                                        <td>&euro; {{ number_format($reservation->total,2,",",".") }}</td>
                                                                        </tfoot>
                                                                    @endif
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if mso]>
                                                    </td>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->


                                                    <!-- FIRMA MESSAGGI -->
                                                    <br>
                                                    {{ @$labels['booking-myarea-email-sollecito-cordiali-saluti'] }}

                                                    <h5 style="font-size: 20px;"><b>{{ @$labels['booking-myarea-email-sollecito-nome-struttura'] }}</b></h5><br>
                                                    <p style="font-size: 15px;">
                                                        {{ @$labels['booking-myarea-email-sollecito-indirizzo-struttura'] }}<br>
                                                        {{ @$labels['booking-myarea-email-sollecito-telefono-label-struttura'] }}: {{ @$labels['booking-myarea-email-sollecito-telefono-struttura'] }}<br>
                                                        {{ @$labels['booking-myarea-email-sollecito-web-label-struttura'] }}: <a href="https://{{ @$labels['booking-myarea-email-sollecito-url-website-struttura'] }}" target="_blank">{{ @$labels['booking-myarea-email-sollecito-url-website-struttura'] }}</a> <br>
                                                        {{ @$labels['booking-myarea-email-sollecito-E-mail-label-struttura'] }}: {{ @$labels['booking-myarea-email-sollecito-email-struttura'] }}<br>
                                                    </p><br><br>
                                                    <p style="font-size: 13px;">{{ @$labels['booking-myarea-label-privacy-testo-footer'] }}: {{ @$labels['booking-myarea-privacy-testo-completo-footer-mail'] }}</p>
                                                    <!-- FINE FIRMA MESSAGGI -->



                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <!--Spazio-->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                                <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 0px;">
                                                    <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <span></span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" id="templateHeader" data-template-container>
                            <!--Contenuto-->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:0px;">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:100%;">

                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <!-- FOOTER // -->
                    <tr>
                        <td align="center" valign="top" id="templateFooter" data-template-container>
                            <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:100%;">
                                <tr>
                                    <td align="center" valign="top" width="600" style="width:100%;">
                            <![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="footerContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
                                            <tbody class="mcnFollowBlockOuter">
                                            <tr>
                                                <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" style="padding-left:9px;padding-right:9px;">
                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td align="center" valign="top">
                                                                                        <!--[if mso]>
                                                                                        <table align="center" border="0" cellspacing="0" cellpadding="0">
                                                                                            <tr>
                                                                                        <![endif]-->

                                                                                        <!--[if mso]>
                                                                                        <td align="center" valign="top">
                                                                                        <![endif]-->
                                                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                                                                        <tbody>
                                                                                                        <tr>
                                                                                                            <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                                                                    <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                                                            <a href="{{ env('APP_URL') }}" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-link-48.png" style="display:block;" height="24" width="24" class=""></a>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <!--[if mso]>
                                                                                        </td>
                                                                                        <![endif]-->
                                                                                        <!--[if mso]>
                                                                                        </tr>
                                                                                        </table>
                                                                                        <![endif]-->
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                    <!--[if mso]>
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                        <tr>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    <td valign="top" width="600" style="width:100%;">
                                                    <![endif]-->
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                ©
                                                                {{ env('PROJECT_NAME') }}

                                                                <br/>

                                                                {{ @$labels['booking-myarea-email-risposta-automatica'] }}

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--[if mso]>
                                                    </td>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>
</body>
</html>

