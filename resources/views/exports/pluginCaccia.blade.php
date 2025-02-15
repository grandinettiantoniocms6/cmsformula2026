<table>
    <tr>
        <th colspan="3"><strong>Graduatoria</strong></th>
    </tr>
</table>

@if($list)
<table>
    <thead>
    <tr>
        <th>
           <strong>Codice</strong>
        </th>
        <th>
            <strong>Nome</strong>
        </th>
        <th>
            <strong>Punti</strong>
        </th>
        <th>
            <strong>Numero Capi</strong>
        </th>
        <th>
            <strong>Tipo Capi</strong>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $item)
        <?php
        $hunter = \App\Models\PluginCacciaHunters::find($item->hunter_id);
        $chiefs = \App\Models\PluginCacciaHuntersPoints::whereNotNull("hunter_chief_id")->get();
        ?>
        <tr>
            <td>
                {{ $hunter->code }}
            </td>
            <td>
                {{ $hunter->first_name }}  {{ $hunter->last_name }}
            </td>
            <td class="float-right">
                {{ $item->tot }}
            </td>
            <td>
                {{ count($chiefs) }}
            </td>

            <td>
                @if($chiefs)
                    @foreach($chiefs as $c)
                        <?php
                        $chief = \App\Models\PluginCacciaChiefs::find($c->chief_id);
                        ?>
                        {{ $c->point }} punti {{ $chief->code }}<br>
                    @endforeach
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif

