@if($itemProduct->attachmentsList)
    <table class="table table-bordered">
        <tbody>
        @foreach($itemProduct->attachmentsList as $attachment)
            <tr>
                <th scope="row"><a href="{{ url("uploads/$attachment->file") }}" target="_blank">{{ $attachment->name }}</a></th>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
