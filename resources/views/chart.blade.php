@extends('layouts.app')

@section('content')
    <h3>Total records {{ $amount }}</h3>
    @foreach($charts as $name => $chart)
        <h1>{{ $name }} Graphs</h1>
        <div style="width: 50%">
            {!! $chart->container() !!}
        </div>
        @if($chart)
            {!! $chart->script() !!}
        @endif
    @endforeach
@endsection
