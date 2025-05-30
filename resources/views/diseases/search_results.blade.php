@extends('layouts.app')

@section('content')
    <h1>Search Results</h1>

    @if($results->isEmpty())
        <p>No diseases found matching your query.</p>
    @else
        <ul>
            @foreach($results as $disease)
                <li>{{ $disease->disease_name }}</li>
            @endforeach
        </ul>
    @endif
@endsection
