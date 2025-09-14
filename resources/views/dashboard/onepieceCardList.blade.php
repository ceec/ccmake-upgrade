@extends('layouts.app')

@section('content')
<div class="container">

    <h1>One Piece Cards</h1>
    

    <div class="row">
    	<div class="col-md-12">
      @foreach($cards as $card)
        {{date('Y-m-d',strtotime($card->created_at))}} <a href="/dashboard/onepiececard/edit/{{$card->id}}">{{ $card->name }}</a><br>

      @endforeach
			
    	</div>
   	</div>

</div>


@endsection
