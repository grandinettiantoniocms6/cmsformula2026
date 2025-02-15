<?php
$labels = \App\Models\PluginBookingLabels::get()->pluck("value", "key")->toArray();

$nome = "";
$cognome = "";

if(\Session::has('user_id')){
    $user = \App\User::find(\Session::get('user_id'));
    if($user){
        $temp = explode(" ", $user->name);
        $nome = trim($temp[0]);

        if(key_exists(1, $temp)){
            $cognome = trim($temp[1]);
        }

        if(key_exists(2, $temp)){
            $cognome .= " $temp[2]";
        }
    }
}
?>
@if($session->qty)
    <form id="form_partecipanti" method="post" class="validation">
        {{ csrf_field() }}
        <?php $qty_final = $session->qty + $session->qty_bimbi; ?>

        @for($i=1; $i<=$qty_final; $i++)
            <h4>{{ @$labels['booking-partecipant-title'] }}{{ $i }}</h4>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">{{ @$labels['booking-partecipant-first-name'] }}</label>
                        <input type="text" name="partecipants[{{ $i }}][first_name]" class="form-control" value="{{ $nome }}" required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">{{ @$labels['booking-partecipant-last-name'] }}</label>
                        <input type="text" name="partecipants[{{ $i }}][last_name]" class="form-control" value="{{ $cognome }}" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">{{ @$labels['booking-partecipant-data'] }}</label>
                        <input type="date" name="partecipants[{{ $i }}][birthdate]" class="form-control" value="" required>
                    </div>
                </div>
                <?php /**
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="partecipants[{{ $i }}][email]" class="form-control" required>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Cellulare</label>
                        <input type="text" name="partecipants[{{ $i }}][mobile]" class="form-control" required>
                    </div>
                </div>
                */ ?>
            </div>
        @endfor


        <div class="mt-4">
            <button type="button" class="btn btn-success btn-lg text-white width-lg-auto width-100" onclick="carica_servizi_2()">{{ @$labels['booking-continua'] }} <i class="bi bi-arrow-right"></i></button>
        </div>
    </form>

    <script>
        $('#form_partecipanti').validate({
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                error.addClass( "invalid-feedback" );

                switch (element.attr("name")) {
                    case 'accept':
                        element.closest('.form-group').append( error );
                        break;
                    default:
                        error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        });
    </script>
@endif
