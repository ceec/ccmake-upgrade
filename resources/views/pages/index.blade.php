@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<style>
.ccmake-cosplay {
	background-color: #e2aef2;
}

.ccmake-programming {
	background-color: #afd2ff;
}

.step-container {
	padding-top: 10px;
	padding-bottom: 5px;
}

.square {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: auto;
    grid-gap: 1rem;
}
</style>
<div class="container">
	<div class="square">
		<div>
			<a href="/pokemon">Pokemon</a>
		</div>
		<div>
			<a href="/onepiece">One Piece</a>
		</div>
		<div>
			<a href="/pokemon/all">Pokemon All</a>
		</div>
		<div>
			<a href="/rocks">Rocks</a>
		</div>
		<div>
			<a href="/music">Music</a>
		</div>
		<div>
		Flights
		</div>
	</div>
</div>
@endsection