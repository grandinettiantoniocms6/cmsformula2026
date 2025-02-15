<table>
    <tr>
        <th colspan="3"><strong>Maison Flâneur</strong></th>
    </tr>
</table>

@if($details)
    <?php
        $user = \App\User::find($order->user_id);
        $symbol = "€";
        if(in_array($user->country_id, config('config.default_country_user_dollar'))){
            $symbol = "$";
        }
        if(in_array($user->country_id, config('config.default_country_user_listino_2'))){
            $symbol = "€";
        }

        $tot_qty = 0;
        foreach ($details as $detail){
            $tot_qty  = $tot_qty + $detail->quantity;
        }
    ?>

<table>
    <tbody>
    <tr>
        <td colspan="2"><b>Order number</b> </td>
        <td>{{ $order->id }}</td>
        <td><b>Total qty</b></td>
        <td>{{ $tot_qty }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Order data</strong></td>
        <td>{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $order->created_at)->format("d/m/Y") }}</td>
        <td><b>Order total</b></td>
        <td>
            {{ number_format($order->total,2,",", ".") }} {{ $symbol }}
        </td>
    </tr>
    <tr>
        <td colspan="2"><strong>Customer</strong></td>
        <td>{{ $user->name }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Customer ref.</strong></td>
        <td>{{ $user->id }}</td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
</table>

<table>
    <thead>
      <tr>
          <?php $td_style = "background-color: #eeeeee; width: 15px; height: 30px; text-align:center; font-weight: bolder;"; ?>
          <td style="<?php echo $td_style; ?>">Image</td>
          <td style="<?php echo $td_style; ?>">Image variant</td>
          <td style="<?php echo $td_style; ?>">Category</td>
          <td style="<?php echo $td_style; ?>">Model name</td>
          <td style="<?php echo $td_style; ?>">Item number</td>
          <td style="<?php echo $td_style; ?>">Color</td>
          <td style="<?php echo $td_style; ?>">SKU</td>
          <td style="<?php echo $td_style; ?>">Description</td>
          <td style="<?php echo $td_style; ?>">Made in</td>

          <?php
          $options = \App\Models\ShopAttributesOptions::where("shop_attribute_id", 2)->get()->pluck('value', 'id')->toArray();
          ?>
          @if(count($options))
              @foreach($options as $id => $opt)
                      <td style="<?php echo $td_style; ?>">{{ $opt }}</td>
              @endforeach
          @endif

          <td style="<?php echo $td_style; ?>">Price</td>
          <td style="<?php echo $td_style; ?>">Delivery_start</td>
          <td style="<?php echo $td_style; ?>">Delivery_end</td>
      </tr>
    </thead>
    <tbody>
    @foreach($details as $detail)
        <?php
        $product = \App\Models\PluginProducts::find($detail->product_id);
        $padre = \App\Models\PluginProducts::where("group_id", $product->group_id)->where("is_variant", 0)->first();
        $category = $product->category();

        $color_label = "";
        $attribute = \App\Models\ShopAttributesProducts::where("product_id", $product->id)->where("attribute_id", 1)->first();
        if($attribute){
            $option = \App\Models\ShopAttributesOptions::find($attribute->option_id);
            if($option){
                $color_label = $option->value;
            }
        }

        $attribute = \App\Models\ShopAttributesProducts::where("product_id", $product->id)->where("attribute_id", 2)->first();
        if($attribute){
            $option = \App\Models\ShopAttributesOptions::find($attribute->option_id);
            if($option){
                $taglia_label = $option->value;
            }
        }
        ?>
        <tr>
            <td>
                <?php
                $cover = $product->getCoverExcel();

                //Resize image here
                $basename = basename($cover);
                $thumbnailpath = public_path($cover);
                $img = \Image::make($thumbnailpath)->resize(35, 35, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save("uploads/thumb/$basename");
                $cover = "uploads/thumb/$basename";
                ?>
                <img width="35" height="35" src="{{ $cover }}" alt="">
            </td>
            <td>
                @if($product->is_variant == 1)
                    <?php
                    if($padre && $product->include_photo_padre == 1){
                        $coverPadre = $padre->getCoverExcel();

                        //Resize image here
                        $basename = basename($coverPadre);
                        $thumbnailpath = public_path($coverPadre);
                        $img = \Image::make($thumbnailpath)->resize(35, 35, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $img->save("uploads/thumb/$basename");
                        $coverPadre = "uploads/thumb/$basename";

                        echo "<img width='35' height='35' src='$coverPadre'>";
                    }
                    ?>
                @endif
            </td>
            <td>
                {{ $category->name }}
            </td>
            <td>
                {{ $padre->sku }}
            </td>
            <td>
                {{ $product->code_article }}
            </td>
            <td>
                {{ $color_label }}
            </td>
            <td>
                {{ $product->sku }}
            </td>
            <td>
                {{ $product->description_short }}
            </td>
            <td>
                {{ $product->custom_1 }}
            </td>
            @if(count($options))
                @foreach($options as $id => $opt)
                    @if($taglia_label == $opt)
                         <td>{{ $detail->quantity }}</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            @endif

            <td>
                @if(env('PROJECT_NAME') != "Maison-Flaneur")
                   {{ $detail->price_with_tax }} {{ $symbol }}
                @else
                    {{ $detail->price }} {{ $symbol }}
                @endif
            </td>
            <td>
               {{ $product->delivery_start }}
            </td>
            <td>
                {{ $product->delivery_end }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif


<br>
<br>
<br>


<table>
    @if(!in_array($user->country_id, config('config.default_country_user_dollar')) || !in_array($user->country_id, config('config.default_country_user_listino_2')))
    <tr>
        <td colspan="20">
            Per visione e accettazione delle retrostanti condizioni generali di vendita
        </td>
    </tr>
    <tr>
        <td colspan="20">
        </td>
    </tr>
    <tr>
        <td colspan="20">
            1° Firma
        </td>
    </tr>
    <tr>
        <td colspan="20">
        </td>
    </tr>
    <tr>
        <td colspan="20">
        </td>
    </tr>
    <tr>
        <td colspan="20">
            Ai sensi e per gli effetti degli art. 1341 e 1342 Cod.Civ:, il compratore dopo aver attentamente letto i contenuti delle clausole delle retrostanti condizioni generali di vendita, approva specificatamente ed espressamente le causole nn. 1, 3, 4, 5, 9, 14.
        </td>
    </tr>
    <tr>
        <td colspan="20">
        </td>
    </tr>
    <tr>
        <td colspan="20">
            2° Firma
        </td>
    </tr>
    <tr>
        <td colspan="20">
        </td>
    </tr>
    <tr>
        <td colspan="20">
        </td>
    </tr>

    <tr>
        <td colspan="20">
            CONDIZIONI GENERALI DI VENDITA
        </td>
    </tr>
    <tr>
        <td colspan="20">
            1) Una volta sottoscritto il presente ordine, è concessa facoltà di revoca al compratore, tramite e-mail da inviarsi alla parte venditrice e all’agente, entro e non oltre 10 giorni dalla data di sottoscrizione, decorso tale termine, l’ordine è da intendersi fisso, vincolante e irrevocabile.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            2) In difetto di conferma d’ordine, parte venditrice potrà in ogni tempo rifiutare l’ordine non accettato.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            3) I termini di consegna richiesti dal compratore sono indicativi e non essenziali.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            4) I pagamenti devono essere eseguiti presso la sede dell’azienda. Il compratore non può, in nessun caso, rifiutare o sospendere il pagamento della merce. L’eventuale emissione di tratte, ricevute bancarie, pagherò, non verrà in nessun caso a modificare il luogo di pagamento, che rimarrà fissato presso la sede di parte venditrice. Ogni cessione viene accettata “pro solvendo”.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            5) Le scadenze di pagamento, eventualmente concesse da parte venditrice, hanno carattere essenziale e il relativo mancato rispetto comporta la decadenza dal beneficio del termine, l’applicazione degli interessi al tasso di mora pari a sei punti in più di Euribor, e l’addebito dei costi di insoluto, fatto salvo il risarcimento del maggior danno.
            In caso di mora nel pagamento da parte del compratore, è inoltre facoltà di parte venditrice sospendere la produzione e la consegna relativa anche a ordini differenti rispetto a quello per il quale v’è mora e inadempimento da parte del compratore.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            6) I prezzi di listino sono fissi, salvo sconti confermati da parte venditrice nella conferma d’ordine.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            7) Il compratore espressamente si assume ogni rischio di sottrazione, perdita ovvero avaria dei beni compravenduti, durante il trasporto per la consegna, anche in ipotesi di vendita franco destino.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            8) Il compratore è consapevole e comunque espressamente autorizza parte venditrice a consegnare gli articoli del presente ordine in via non contestuale. Al riguardo il compratore espressamente
            riconosce che detti articoli sono da considerarsi beni individuali e pertanto eventuali contestazioni sulla consegna o sulla spedizione di singoli capi non è in grado di inficiare la validità dell’intero
            ordine.        </td>
    </tr>
    <tr>
        <td colspan="20">
            9) Ricevuta la merce, eventuali contestazioni su vizi sono da inviare per iscritto al venditore entro il termine massimo di giorni dieci dal ricevimento. Differenze non evitabili di carattere tecnico riguardanti la qualità, il colore, la larghezza, la lunghezza, il peso , le finiture, la vestibilità dei capi non potranno essere oggetto di reclamo. L’accertamento dei vizi dà diritto unicamente alla sostituzione o riparazione del capo viziato, con esclusione di ogni ulteriore risarcimento. L’invio della contestazione non legittima il mancato pagamento da parte del compratore alle scadenze prestabilite né, in mancanza di espressa autorizzazione, la restituzione dei beni che si assumono viziati. Tutti i resi non autorizzati saranno respinti con rinvio al compratore ovvero tenuti a disposizione con spese a suo carico.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            10) Il compratore dichiara espressamente di agire esclusivamente per scopi inerenti alla propria attività professionale o imprenditoriale.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            11) Ogni modificazione alle suddette condizioni generali dovrà essere apportata e provata per iscritto.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            12) Ogni eventuale esclusiva di vendita potrà essere concessa unicamente e per iscritto da BLOCK INDUSTRIE s.r.l.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            13) Ai sensi del d.lgs.n°196/2003,con la sottoscrizione del presente ordine si autorizza espressamente il trattamento dei dati personali nell’ambito del rapporto commerciale fra le parti intercorso.
        </td>
    </tr>
    <tr>
        <td colspan="20">
            14) Per qualsiasi controversia relativa alla validità, interpretazione, esecuzione o risoluzione del contratto di vendita, competente a decidere sarà in via esclusiva l’Autorità Giudiziaria del Foro di Padova.
        </td>
    </tr>
    <tr>
        <td colspan="20">
        </td>
    </tr>

    @else
        <tr>
            <td colspan="20">
                I have read and hereby accept the general terms of sale appearing on the overleaf.
            </td>
        </tr>
        <tr>
            <td colspan="20">
            </td>
        </tr>
        <tr>
            <td colspan="20">
                1° Signature
            </td>
        </tr>
        <tr>
            <td colspan="20">
            </td>
        </tr>
        <tr>
            <td colspan="20">
            </td>
        </tr>
        <tr>
            <td colspan="20">
                After carefully reading the clauses of the general terms of sale appearing on the overleaf, and for purposes and effects of Articles 1341 and 1342 of the Italian Civil Code, the buyer hereby specifically and expressly approves clauses 1, 3, 4, 5, 9, 14 .
            </td>
        </tr>
        <tr>
            <td colspan="20">
            </td>
        </tr>
        <tr>
            <td colspan="20">
                2° Signature
            </td>
        </tr>
        <tr>
            <td colspan="20">
            </td>
        </tr>
        <tr>
            <td colspan="20">
            </td>
        </tr>
    <tr>
        <td colspan="20">
            GENERAL TERMS OF SALE
        </td>
    </tr>

    <tr>
        <td colspan="20">
            1) Once this order has been signed, the buyer has the right to cancel it (by means of registered letter with return receipt mailed to the seller and to the agent no later than 10 (ten) days after the signing date after such deadline, this order is considered fixed, binding and irrevocable.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            2) In the absence of confirmation, the seller may reject this order at any time.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            3) The buyer’s requested delivery dates are approximate and not essential.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            4) Payments must be effected at the company’s main office. Under no circumstances may the buyer refuse or suspend payment of the goods. Any issuance of drafts, cash orders, or IOUs will in no way modify the payment site, which will remain the seller’s main office. All endorsed bills are accepted ”pro solvendo”.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            5) Any payment deadlines granted by the seller are essential in nature, and any failure to respect such deadlines will result in cancellation of the benefit of the deadline, the application of interest on delayed payment at the EURIBOR rate plus six points, the charging of expenses for the undischarged debt, as well as reimbursement of damages.
            If the buyer is overdue in making payment, the seller will also have the right to suspend the production and delivery of orders other than the one for which the buyer is overdue and in default.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            6) List prices are fixed unless the seller confirms discounts in its confirmation of order.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            7) The buyer expressly assumes all risk of pilferage, loss, or average of the goods traded during transport for delivery, even in case of sales that are carriage-paid.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            8) The buyer has been informed and expressly authorizes the seller to deliver the articles in this order in more than one shipment. In this regard, the buyer expressly acknowledges that such articles are
            to be considered individual goods, and therefore any disputes concerning the delivery or shipment of individual articles will not compromise the validity of the order as a whole.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            9) Any complaints regarding defects must be sent to the seller in writing within a maximum of ten days after receipt of the goods. Unavoidable technical differences pertaining to the quality, color, width, length, weight, finishings, and/or fit of the articles may not be the subject matter of complaint. Upon confirmation of defects, the buyer’s sole right will be to have the article replaced or repaired, with exclusion of any other compensation. Transmission of a complaint does not justify the buyer’s failure to make payment at the set deadlines or (without the seller’s express authorization) the return of any allegedly defective goods. All unauthorized returns will be refused and sent back to the buyer or held by the seller at the buyer’s expense.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            10) The buyer expressly declares that he/she is acting exclusively for purposes inherent to his/her professional or entrepreneurial business.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            11) Any and all changes to these general terms must be made and approved in writing.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            12) Any exclusive agency may be granted in writing only by BLOCK INDUSTRIE s.r.l.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            13) For purposes of Leg. Decree no. 196/2003, signing this order expressly authorizes the treatment of personal data in the context of the business relationship between the parties.
        </td>
    </tr>

    <tr>
        <td colspan="20">
            14) The Court of Padova, Italy will have exclusive jurisdiction over any and all disputes pertaining to the validity, interpretation, performance or cancellation of this sales contract.
        </td>
    </tr>
    @endif
</table>
