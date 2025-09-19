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
                $('#popup_setting').modal('show');
                @else
                @if($website->popup_pages == 2)
                $('#popup_setting').modal('show');
                @endif
                @endif
            });
        </script>
    @endif
@endif

<div class="modal" id="popup_setting" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $website->popup_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                {!! $website->popup_text !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-small btn-round-edge btn-box-shadow fw-700" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

