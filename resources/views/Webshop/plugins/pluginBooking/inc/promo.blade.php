<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();
?>
@if($room->promo_price !== null && trim($room->promo_price) != "" && $room->data_promo_end)
    @if($room->hidden_promo_countdown == 0)
        <!-- Display the countdown timer in an element -->
        <div id="promo_{{ $room->id }}"></div>

        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("{{ $room->data_promo_end }}").getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("promo_{{ $room->id }}").innerHTML = "<div>{{ @$labels['booking-offerta-scade']}}: </div> <div class='main_timer'><div class='timer_block'><span class='timer_block-number' id='days'>" + days + "</span> Giorni</div> <div class='timer_block'><span class='timer_block-number' id='hours'>" + hours + "</span> Ore</div> <div class='timer_block'><span class='timer_block-number' id='min'>"+ minutes + "</span> Min</div> <div class='timer_block'><span class='timer_block-number' id='sec'>" + seconds + "</span> Sec</div></div>";

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    $('#promo').hide();

                    document.getElementById("promo_{{ $room->id }}").innerHTML = "Scaduta";
                }
            }, 1000);
        </script>
    @endif
@endif

