<div class="form-group">
    <label>{!! $field['label'] !!}</label>
    <div class="input-group">
        <span class="input-group-btn">
            <a id="lfm_{{ $field['name'] }}" data-input="{{ $field['name'] }}" data-preview="holder_{{ $field['name'] }}" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> Choose
            </a>
        </span>
        <input id="{{ $field['name'] }}" class="form-control" type="text" name="{{ $field['name'] }}" value="{{ old($field['name']) ?? $field['value'] ?? '' }}">
    </div>
    <img id="holder_{{ $field['name'] }}" style="margin-top:15px;max-height:100px;">
</div>

@push('crud_fields_scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm_{{ $field['name'] }}').filemanager('image', { prefix: '/laravel-filemanager' });
</script>
@endpush
