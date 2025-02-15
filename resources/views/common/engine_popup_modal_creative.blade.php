@if($website->popup_start && $website->popup_end)
    <?php
    $start = \Carbon\Carbon::createFromFormat("Y-m-d", $website->popup_start);
    $end = \Carbon\Carbon::createFromFormat("Y-m-d", $website->popup_end);
    $now = \Carbon\Carbon::now();
    ?>
    @if($now->gte($start) && $now->lte($end))
        <script type="text/javascript">
            $(window).on('load', function() {
                @if($website->popup_pages == 1 && \Route::currentRouteName() == "index")
                $('#popupadmin').modal('show');
                @else
                @if($website->popup_pages == 2)
                $('#popupadmin').modal('show');
                @endif
                @endif
            });
        </script>
    @endif
@endif

<div class="modal" id="popupadmin">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $website->popup_title }}</h5>

            </div>
            <div class="modal-body">
                {!! $website->popup_text !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="theme-btn-four" data-fancybox-close="">Chiudi</button>
            </div>
        </div>
    </div>
</div>



