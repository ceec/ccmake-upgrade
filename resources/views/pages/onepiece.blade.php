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
<h2>the One Piece is real</h2>
    @foreach ($sets as $set)
        {{$set->totalhavecards()}}/{{$set->totalcards()}}  <a href="/onepiece/set/{{$set->url}}">{{$set->name}}</a><br>
    @endforeach
<h2>need</h2>
	@foreach ($sets as $set)
        {{$set->totalneedcards()}}/{{$set->totalcards()}}<a href="/onepiece/need/{{$set->url}}">{{$set->name}}</a><br>
	@endforeach
</div>

@endsection