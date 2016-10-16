@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>My subscriptions</h1>
            <ul>
            @forelse (auth()->user()->subscriptions as $subscription)
                <li>{{ $subscription->series->title }} <a href="/series/{{ $subscription->series->id }}/subscriptions/delete">Un-Watch</a></li>
            @empty
                <li>None yet!</li>
            @endforelse
            </ul>

            <h1>All Marvel Series</h1>

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
        </div>
    </div>
</div>
@endsection
