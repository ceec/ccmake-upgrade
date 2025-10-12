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
        <h2><a href="/pokemon">Sets</a> > <a href="/pokemon/set/{{$set->url}}">{{$set->name}}</a> | <a href="/pokemon/need/{{$set->url}}">Need</a></h2>
<div class="cards">
    @foreach ($cards as $card)
        <div id="{{$card->pokemoncardid}}">
            <span class="set-number">{{$card->set_number}}</span> <a href="{{$set->url}}/{{$card->pokemoncardid}}">{{$card->name}}</a><br>
            @if ($card->user_id)
                @if ($card->set_id == 98 || $card->set_id == 109 || $card->set_id == 118 || $card->set_id == 119 || $card->set_id > 120)
                <img class="card-image" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.png"><br>
                @else
                <img class="card-image" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.jpg"><br>
                @endif
            @if ($card->price > 0.00)
                ${{$card->price}}
            @endif
            {{$card->source}}
            @else
            @if (!Auth::guest())
            <form method="POST" action="/add/pokemonusercard">
                @csrf
                <input type="hidden" name="user_id" value="1" />
                <input type="hidden" name="set_id" value={{$card->set_id}} />
                <input type="hidden" name="pokemoncard_id" value={{$card->pokemoncardid}} />     
                <button type="submit">
                    Add
                </button>
            </form>
            @endif
            @if ($card->set_id == 98 || $card->set_id == 109 || $card->set_id == 118 || $card->set_id == 119 || $card->set_id > 120)
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