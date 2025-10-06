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
@foreach ($vintage as $set)
<img src="/images/pokemon/seticons/{{$set->id}}.png" height="15px"> {{$set->totalhavecards()}}/{{$set->totalcards()}}  <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
@endforeach
<br>
@foreach ($five as $set)
    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="15px"> {{$set->totalhavecards()}}/{{$set->totalcards()}}  <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
@endforeach
<br>
@foreach ($six as $set)
    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="15px"> {{$set->totalhavecards()}}/{{$set->totalcards()}}  <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
@endforeach
<br>
@foreach ($modern as $set)
    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="15px"> {{$set->totalhavecards()}}/{{$set->totalcards()}}  <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
@endforeach
<h2>need</h2>
	@foreach ($vintage as $set)
    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="15px"> {{$set->totalneedcards()}}/{{$set->totalcards()}}<a href="/pokemon/need/{{$set->url}}">{{$set->name}}</a><br>
	@endforeach
</div>

@endsection