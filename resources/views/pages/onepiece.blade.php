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
		<div class="row">
        	<div class="col-md-4">
				<h2>the One Piece is real</h2>
				@foreach ($mainsets as $set)
					{{$set->shortname}} - {{$set->totalhavecards()}}/{{$set->totalcards()}} - <a href="/onepiece/set/{{$set->url}}">{{$set->name}}</a><br>
				@endforeach
			</div>
			<div class="col-md-6">
				<h2>Other stuff</h2>
				@foreach ($other as $set)
					{{$set->shortname}} - {{$set->totalhavecards()}}/{{$set->totalcards()}} - <a href="/onepiece/set/{{$set->url}}">{{$set->name}}</a><br>
				@endforeach
			</div>
			<div class="col-md-2">
				<h2>Starter Decks</h2>
				@foreach ($starterdecks as $set)
					{{$set->shortname}} - {{$set->totalhavecards()}}/{{$set->totalcards()}} - <a href="/onepiece/set/{{$set->url}}">{{$set->name}}</a><br>
				@endforeach
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-4">
			</div>
		</div>
</div>

@endsection