@php
    $popupText = trim((string) $website->popup_text);
    $popupIsInDateRange = false;
    $popupIsVisibleOnPage = (int) $website->popup_pages === 2
        || ((int) $website->popup_pages === 1 && \Route::currentRouteName() === 'index');

    if ($popupText !== '' && $website->popup_start && $website->popup_end) {
        try {
            $popupStart = \Carbon\Carbon::parse($website->popup_start)->startOfDay();
            $popupEnd = \Carbon\Carbon::parse($website->popup_end)->endOfDay();
            $popupIsInDateRange = \Carbon\Carbon::now()->betweenIncluded($popupStart, $popupEnd);
        } catch (\Exception $exception) {
            $popupIsInDateRange = false;
        }
    }
@endphp

@if($popupIsInDateRange && $popupIsVisibleOnPage)
    <div class="modal fade" id="popup_setting" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $website->popup_title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <script>
        window.addEventListener('load', function () {
            var popup = document.getElementById('popup_setting');

            if (!popup) {
                return;
            }

            if (window.bootstrap && window.bootstrap.Modal) {
                window.bootstrap.Modal.getOrCreateInstance(popup).show();
                return;
            }

            if (window.jQuery && jQuery.fn.modal) {
                jQuery(popup).modal('show');
            }
        });
    </script>
@endif

