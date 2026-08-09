@extends('layouts.app')

@section('content')
<div class="container">

    <h1>One Piece Rarities</h1>
    
    <div class="row">
    	<div class="col-md-12">
      @foreach($rarities as $rarity)
        {{date('Y-m-d',strtotime($rarity->created_at))}} <a href="/dashboard/onepiecerarity/edit/{{$rarity->id}}">{{ $rarity->name }}</a><br>

      @endforeach
			
    	</div>
   	</div>

</div>


@endsection
