@if(!empty($answer))
    <ul>
        @foreach($answer as $singleAnswer)
            <li>{{ $singleAnswer['answer'] }}</li>
        @endforeach
    </ul>
@else
    <li>No users found</li>
@endif

