<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Q: {{ $row->question }}</h5>
        @if(!empty($row->getAnswer))
            @foreach($row->getAnswer as $singleAns)
                <p class="card-text"><strong>A:</strong> {{ $singleAns->answer }}</p>
            @endforeach
        @endif
        <button type="button" class="btn btn-small btn-info btn-xs">Added On - {{ $row->created_at->format('F j, Y h:i A') }}</button>
        <button type="button" class="btn btn-small btn-info btn-xs">Added by - {{ $row->getUser->name }}</button>
    </div>
</div>