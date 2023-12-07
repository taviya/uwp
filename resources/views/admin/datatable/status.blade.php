@if($status)
    <button type="button" class="btn btn-block btn-success btn-xs status_list" data-id="{{$id}}">Active</button>
@else
    <button type="button" class="btn btn-block btn-danger btn-xs status_list" data-id="{{$id}}">Deactive</button>
@endif