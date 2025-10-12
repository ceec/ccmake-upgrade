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
        <h2>vintage</h2>
        <div class="row">
            @foreach ($vintage as $set)
                <div class="col-md-3">
                    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="20px">
                    <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
                </div>
            @endforeach
        </div>
        <br><br>
        <h2>Gen 5</h2>
        <div class="row">
            @foreach ($five as $set)
                <div class="col-md-3">
                    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="20px">
                    <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
                </div>
            @endforeach
        </div>
        <br><br>
        <h2>Gen 6</h2>
        <div class="row">
            @foreach ($six as $set)
                <div class="col-md-3">
                    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="20px">
                    <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
                </div>
            @endforeach
        </div>
        <br><br>
        <h2>Sword and Sheild</h2>
        <div class="row">
            @foreach ($swsh as $set)
                <div class="col-md-3">
                    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="20px">
                    <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
                </div>
            @endforeach
        </div>
        <br><br>
        <h2>Scarlet and Violet</h2>
        <div class="row">
            @foreach ($sv as $set)
                <div class="col-md-3">
                    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="20px">
                    <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
                </div>
            @endforeach
        </div>
        <br><br>
        <h2>Mega</h2>
        <div class="row">
            @foreach ($six as $set)
                <div class="col-md-3">
                    <img src="/images/pokemon/seticons/{{$set->id}}.png" height="20px">
                    <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a><br>
                </div>
            @endforeach
        </div>
@endsection