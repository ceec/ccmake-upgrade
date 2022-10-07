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

.have {

}

.dont-have {
    opacity: 0.4;
}

.card-image {
    max-width:100%;
    height:auto;
}

</style>
	<div class="container">
<h2><a href="/pokemon">Sets</a> > {{$set->name}}</h2>
<div class="cards">
    @foreach ($cards as $card)
        <div>
            <a href="">{{$card->name}}</a> {{$card->set_number}}<br>
            @if ($card->user_id)
            <img class="card-image" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.jpg"><br>
            @else
            <img class="card-image dont-have" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.jpg"><br>
            @endif
        </div>
    @endforeach
</div>
	</div>

@endsection