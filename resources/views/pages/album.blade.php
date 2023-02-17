@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<style>
.cosplay {
	background-color: #e2aef2;
}

.programming {
	background-color: #afd2ff;
}

.step-container {
	padding-top: 10px;
	padding-bottom: 5px;
}
</style>
<div class="container">
<a href="/music">Songs</a><br>
<h1>{{$album->name}}</h1> by 

@foreach ($songs as $song)

{{$song->name}}<br>

@endforeach


</div>        

@endsection