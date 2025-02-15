<table>
    <tr>
        <th colspan="3"><strong>Entrate del {{ \Carbon\Carbon::createFromFormat("Y-m-d", $date)->format("d/m/Y") }}</strong></th>
    </tr>
</table>

@if($reservations_in)
    <table class="table">
        <thead>
        <tr>
            <th>Nome Cognome</th>
            <th>Telefono</th>
            <th>Nr.Pass</th>
            <th>Targa</th>
            <th>Ora</th>
            <th>Tipo Park</th>
            <th>Stato</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservations_in as $item)
            <?php
            $item->mobile = trim(str_replace("+", "", $item->mobile));
            ?>
            <tr>
                <td>{{ $item->name }}</td>
                <td>&nbsp;<?php echo "$item->mobile"; ?></td>
                <td>{{ $item->number_partecipants }}</td>
                <td>{{ $item->targa }}</td>
                <td>{{ \Carbon\Carbon::createFromFormat("H:i:s", $item->time_start)->format("H:i") }}</td>
                <td>
                    @if($item->type_park == 1)
                        SC
                    @endif
                    @if($item->type_park == 2)
                        CO
                    @endif
                </td>
                <td>
                    @if($item->is_checkin == 1)
                        SI
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endif

<table>
    <tr>
        <th colspan="3"><strong>Uscite del {{ \Carbon\Carbon::createFromFormat("Y-m-d", $date)->format("d/m/Y") }}</strong></th>
    </tr>
</table>

@if($reservations_out)
    <table class="table">
        <thead>
        <tr>
            <th>Nome Cognome</th>
            <th>Telefono</th>
            <th>Nr.Pass</th>
            <th>Targa</th>
            <th>Volo rientro</th>
            <th>Ora</th>
            <th>Tipo Park</th>
            <th>Prezzo</th>
            <th>Stato</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservations_out as $item)
            <?php
            $item->mobile = trim(str_replace("+", "", $item->mobile));
            ?>
            <tr>
                <td>{{ $item->name }}</td>
                <td>&nbsp;<?php echo "$item->mobile"; ?></td>
                <td>{{ $item->number_partecipants }}</td>
                <td>{{ $item->targa }}</td>
                <td>{{ $item->number_flight }}</td>
                <td>{{ \Carbon\Carbon::createFromFormat("H:i:s", $item->time_end)->format("H:i") }}</td>
                <td>
                    @if($item->type_park == 1)
                        SC
                    @endif
                    @if($item->type_park == 2)
                        CO
                    @endif
                </td>
                <td>
                    {{ $item->total }}
                </td>
                <td>
                    @if($item->is_payed == 1)
                        SI
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
