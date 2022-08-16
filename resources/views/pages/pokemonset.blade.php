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

.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
}

.card {
    background-color: lightgray;
    border: 2px solid #e7e7e7;
    border-radius: 4px; 
    padding: .5rem;
}

.cardIHave {
    background-color: white;
    border: 2px solid #e7e7e7;
    border-radius: 4px; 
    padding: .5rem;
}


</style>
	<div class="container">
<h2><a href="/pokemon">Sets</a> > {{$set->name}}</h2>
<div class="cards">
    @foreach ($cards as $card)
        @if ($card->user_id)
        <div class="cardIHave">
        @else
        <div class="card">
        @endif
            <a href="">{{$card->name}}</a><br>
            <img src=""><br>
            {{$card->rarity_id}}

        </div>
    @endforeach
</div>
	</div>

@endsection