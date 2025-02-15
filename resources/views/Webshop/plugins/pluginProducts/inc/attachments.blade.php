@if($itemProduct->attachmentsList)
    <table class="table table-sm table-bordered my-0">
        <tbody>
        @foreach($itemProduct->attachmentsList as $attachment)
            <tr>
                <th scope="row"><a href="{{ url("$attachment->file") }}" target="_blank">{{ $attachment->name }}</a></th>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
