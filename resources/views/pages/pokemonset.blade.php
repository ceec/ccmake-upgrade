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
<h2><a href="/pokemon">Sets</a> > {{$set->name}}</h2>
<div class="cards">
    @foreach ($cards as $card)
        <div>
            <span class="set-number">{{$card->set_number}}</span> <a href="/pokemon/{{$card->pokemon_id}}">{{$card->name}}</a><br>
            @if ($card->user_id)
                @if ($card->set_id > 117)
                <img class="card-image" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.png"><br>
                @else
                <img class="card-image" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.jpg"><br>
                @endif
            @if ($card->price > 0.00)
                ${{$card->price}}
            @endif
            {{$card->source}}
            @else
            @if ($card->set_id > 117)
                <img class="card-image dont-have" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.png"><br>
                @else
                <img class="card-image dont-have" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.jpg"><br>
                @endif
            @endif
        </div>
    @endforeach
</div>
	</div>

@endsection