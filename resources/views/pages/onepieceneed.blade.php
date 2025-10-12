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

.set-number {
}

</style>
	<div class="container">
<h2>Need</h2>
<div>
    <h2><a href="/onepiece">Sets</a> > <a href="/onepiece/set/{{$set->url}}">{{$set->name}}</a> | <a href="/onepiece/need/{{$set->url}}">Need</a></h2>
        <div class="cards">
            @foreach ($cards as $card)
            <div>
                <span class="set-number">{{$card->set_number}}</span>  <a href="/onepiece/set/{{$set->url}}/{{$card->id}}">{{$card->name}}</a><br>
                @if ( $card->card_number == 1 )
                <img class="card-image" src="/images/onepiece/{{$set->shortname}}/{{$set->imagenumber()}}-{{$card->set_number}}.png"><br>
                @elseif ( $card->original_set_id != 0 )
                <img class="card-image" src="/images/onepiece/{{$card->set_url}}/{{$card->set_imagename}}-{{$card->original_set_number}}-{{$card->card_number}}.png"><br>
                @else
                <img class="card-image" src="/images/onepiece/{{$set->shortname}}/{{$set->imagenumber()}}-{{$card->set_number}}-{{$card->card_number}}.png"><br>
                @endif
                {{ $card->lastPrice()}}
                <br>
            </div>
            @endforeach
        </div>
</div>

@endsection