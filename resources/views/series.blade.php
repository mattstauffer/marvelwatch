<h1>Marvel Series</h1>

<ul>
@foreach ($series as $serie)
    <li>{{ $serie->title }}

        @if (auth()->user()->subscribedTo($serie->id))
        <a href="/series/{{ $serie->id }}/subscriptions/delete">Un-Watch</a>
        @else
        <a href="/series/{{ $serie->id }}/subscriptions/post">Watch</a>
        @endif
    </li>
@endforeach
</ul>
