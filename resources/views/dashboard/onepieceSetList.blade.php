@extends('layouts.app')

@section('content')
<div class="container">

    <h1>One Piece Sets</h1>
    

    <div class="row">
    	<div class="col-md-12">
      @foreach($sets as $set)
        {{date('Y-m-d',strtotime($set->release_date))}} <a href="/dashboard/onepieceset/edit/{{$set->id}}">{{ $set->name }}</a><br>

      @endforeach
			
    	</div>
   	</div>

</div>


@endsection
