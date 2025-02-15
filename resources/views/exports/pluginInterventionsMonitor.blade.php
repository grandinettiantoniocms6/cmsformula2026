<table>
    <tr>
        <th colspan="3"><strong>Interventi del {{ \Carbon\Carbon::createFromFormat("Y-m-d", $date)->format("d/m/Y") }}</strong></th>
    </tr>
</table>

@if($reservations)
    <table class="table">
        <thead>
        <tr>
            <th>Data</th>
            <th>Orario</th>
            <th>Cliente</th>
            <th>Indirizzo</th>
            <th>Civico</th>
            <th>Interno</th>
            <th>Frazione</th>
            <th>Cap</th>
            <th>Comune</th>
            <th>Provincia</th>
            <th>Cellulare</th>
            <th>Mezzo</th>
            <th>Autista</th>
            <th>Manovale</th>
            <th>Stato</th>
            <th>Priorità</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservations as $item)
            <?php
            $item->mobile = trim(str_replace("+", "", $item->mobile));
            ?>
            <tr>
                <td>
                    <?php
                    $date_it = \Carbon\Carbon::createFromFormat("Y-m-d", $item->date_intervention)->format("d/m/Y");
                    ?>
                    {{ $date_it }}
                </td>
                <td>
                    <?php
                    if($item->is_all_day){
                        echo "Tutto il giorno";
                    }else{
                        $start = "";
                        $end = "";
                        if($item->start){
                            $start = \Carbon\Carbon::createFromFormat("H:i:s", $item->start)->format("H:i");
                        }
                        if($item->end){
                            $end = \Carbon\Carbon::createFromFormat("H:i:s", $item->end)->format("H:i");
                        }

                        echo "Dalle $start alle $end";
                    }
                    ?>
                </td>
                <td>
                    {{ $item->first_name }} {{ $item->last_name }}
                </td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->civico }}</td>
                <td>{{ $item->interno }}</td>
                <td>{{ $item->frazione }}</td>
                <td>{{ $item->cap }}</td>
                <td>{{ $item->comune }}</td>
                <td>{{ $item->provincia }}</td>
                <td>{{ $item->mobile }}</td>
                <td>
                    {{ $item->vehicle->name }}
                </td>
                <td>
                    @if($item->driver)
                        {{ $item->driver->first_name }} {{ $item->driver->last_name }}
                    @endif
                </td>
                <td>
                    @if($item->laborer)
                        {{ $item->laborer->first_name }} {{ $item->laborer->last_name }}
                    @endif
                </td>
                <td>
                    @if($item->status)
                        {!! $item->getStatus() !!}
                    @endif
                </td>
                <td>
                    @if($item->is_priority)
                        SI
                    @else
                        NO
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endif

