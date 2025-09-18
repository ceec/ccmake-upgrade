@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Pokemon Sets</h1>
    

    <div class="row">
    	<div class="col-md-12">
      @foreach($sets as $set)
        {{date('Y-m-d',strtotime($set->release_date))}} <a href="/dashboard/pokemonset/edit/{{$set->id}}">{{ $set->name }}</a><br>

      @endforeach
			
    	</div>
   	</div>

</div>


@endsection
