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
<h2>pokemans</h2>

@foreach ($sets as $set)
    <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
@endforeach
	</div>

@endsection