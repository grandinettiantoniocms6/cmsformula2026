@if($room->total_euro_rooms > 0)
    <div class="prices">
        <ins class="new-price">&euro; {{ number_format($room->total_euro_rooms, 2, ",", ".") }}</ins><span class="unit"></span>
    </div>
    @if(count($session->days))
        {!! $room->listino !!}
    @endif
@endif


