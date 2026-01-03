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
        <h2><a href="/onepiece">Characters</a></h2>
        <div class="cards">
            @foreach ($favs as $character)
                <div id="{{$character->id}}">
                <a href="/onepiece/character/{{$character->id}}">{{$character->name}}</a>

                </div>
            @endforeach      
        </div>
        <hr>
        <div class="cards">
            @foreach ($characters as $character)
                <div id="{{$character->id}}">
                <a href="/onepiece/character/{{$character->id}}">{{$character->name}}</a>

                </div>
            @endforeach
        </div>
	</div>

@endsection