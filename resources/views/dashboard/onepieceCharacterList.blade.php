@extends('layouts.app')

@section('content')
<div class="container">

    <h1>One Piece Characters</h1>
    
    <div class="row">
    	<div class="col-md-12">
      @foreach($characters as $character)
        {{date('Y-m-d',strtotime($character->created_at))}} <a href="/dashboard/onepiececharacter/edit/{{$character->id}}">{{ $character->name }}</a><br>

      @endforeach
			
    	</div>
   	</div>

</div>


@endsection
