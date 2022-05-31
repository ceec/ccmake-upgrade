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
<h2>{{$set->name}}</h2>

@foreach ($cards as $card)
    {{$card->name}}</a><br>
@endforeach
	</div>

@endsection