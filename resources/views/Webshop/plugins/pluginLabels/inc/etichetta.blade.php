<div class="label-container">
    <div class="table-cell">
        <div class="label-wrapper" id="wrapper-{{ $label->format }}">
            @if($setting->logo && $label->is_logo_header)
                <div id="logo-container">
                    <img src="{{ url($setting->logo) }}">
                </div>
            @endif

            <?php
              $label_temp = \DB::table("plugins_labels")->where("id", $label->id)->first();


              switch ($label->lang){
                  case "it":
                  case "en":
                      $title = json_decode($label_temp->title, true);
                      if(!key_exists($label->lang, $title)){
                          $title[$label->lang] = "";
                      }
                      $label->title = $title[$label->lang];

                      $ingredients = json_decode($label_temp->ingredients, true);
                      if(!key_exists($label->lang, $ingredients)){
                          $ingredients[$label->lang] = "";
                      }
                      $label->ingredients = $ingredients[$label->lang];

                      $description = json_decode($label_temp->description, true);
                      if(!key_exists($label->lang, $description)){
                          $description[$label->lang] = "";
                      }
                      $label->description = $description[$label->lang];

                      $table_nutr = json_decode($label_temp->table_nutr, true);
                      if(!key_exists($label->lang, $table_nutr)){
                          $table_nutr[$label->lang] = "";
                      }
                      $label->table_nutr = $table_nutr[$label->lang];

                      break;
                  default:
                      $title = json_decode($label_temp->title, true);
                      if(!key_exists("it", $title)){
                          $title["it"] = "";
                      }
                      $label->title = $title["it"];


                      $ingredients = json_decode($label_temp->ingredients, true);
                      if(!key_exists("it", $ingredients)){
                          $ingredients["it"] = "";
                      }
                      $label->ingredients = $ingredients["it"];

                      $description = json_decode($label_temp->description, true);
                      if(!key_exists("it", $description)){
                          $description["it"] = "";
                      }
                      $label->description = $description["it"];

                      $table_nutr = json_decode($label_temp->table_nutr, true);
                      if(!key_exists("it", $table_nutr)){
                          $table_nutr["it"] = "";
                      }
                      $label->table_nutr = $table_nutr["it"];


                      break;
              }
            ?>

            @if($label->title && trim($label->title != ""))
                <div class="title-container">
                    <h1>{{ $label->title }}</h1>
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
                    @if($label->lang == 'it')
                        <p>Prodotto in laboratorio che usa anche nocciole, frutta con guscio, latte, uova</p>
                    @endif
                    @if($label->lang == 'en')
                        <p>Produced in the laboratory that also uses peanuts, nuts, milk, sesame and eggs</p>
                    @endif
                    @if($label->lang == 'it/en')
                        <p>Prodotto in laboratorio che usa anche nocciole, frutta con guscio, latte, uova</p>
                        <p>Produced in the laboratory that also uses peanuts, nuts, milk, sesame and eggs</p>
                    @endif

                </div>
            @endif

            @if($label->is_product_lab)
                <div id="tabella-nutrizionale">
                    {!! $label->table_nutr !!}
                </div>
            @endif

            @if($label->qrcode_link && trim($label->qrcode_link != ""))
                <div class="footer-container" style="@if($setting->photo) background-image: url({{ url($setting->photo) }}); @endif">
                    <div class="qr-code">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->color(126,89,68)->backgroundColor(244,224,185)->generate($label->qrcode_link); !!}
                    </div>
                </div>
            @endif

            <div class="address-container">

                @if($label->is_address_footer)
                    @if($label->lang == 'it')
                        <div class="title">Prodotto e confezionato da:</div>
                    @endif
                    @if($label->lang == 'en')
                       <div class="title">Produced and packaged by:</div>
                    @endif
                    @if($label->lang == 'it/en')
                        <div class="title">Prodotto e confezionato da:</div>
                        <div class="title">Produced and packaged by:</div>
                    @endif

                    {!! $setting->address !!}
                @endif

                @if($label->barcode && trim($label->barcode != ""))
                    <div id="barcode">
                        <?php
                            $class = new \Milon\Barcode\DNS1D();
                            // echo $class->getBarcodeHTML($label->barcode, 'EAN13');
                            echo '<img src="data:image/jpeg;base64,' . DNS1D::getBarcodePNG($label->barcode, 'EAN13',3,70,array(126,89,68), true) . '" alt="barcode" />';
                        ?>
                    </div>
                @endif
            </div>
            <div id="weight-container">
                <div class="small-border"></div>
                <table>
                    <tr>
                        <td>
                            @if($label->lang == 'it')
                                Peso:
                            @endif
                            @if($label->lang == 'en')
                                Weight:
                            @endif
                            @if($label->lang == 'it/en')
                                Peso/Weight:
                            @endif
                            <strong>{{ $label->weight }}</strong></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>Prod:

                            <strong>{{ $label->production }}</strong></td>
                        <td>
                            @if($label->lang == 'it')
                                Scad:
                            @endif
                            @if($label->lang == 'en')
                                Exp:
                            @endif
                            @if($label->lang == 'it/en')
                                Scad/Exp:
                            @endif

                            <strong>{{ $label->end_date }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
