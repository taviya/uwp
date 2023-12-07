@if(!empty($answer))
    @foreach($answer as $singleAnswer)
        <p> <strong>A:</strong> {{ $singleAnswer['answer'] }}</p>
    @endforeach
@else
    <p>No users found</p>
@endif