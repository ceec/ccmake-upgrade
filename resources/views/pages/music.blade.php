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
</style>
<div class="container">
		<table class="table">
		<thead>
			<tr>
      <td>Name</td>
      <td>Length</td>
			<td>Artist</td>
			<td>Album</td>
      <td>Track</td>
      <td>Plays</td>
			</tr>
		</thead>
        @foreach($songs as $song)
<tr>
    <td>{{$song->name}}</td>
    <?php //gross formatting of miliseconds
                $milliseconds = $song->length;
                $seconds = floor($milliseconds/1000);
                $minutes = round(floor($seconds/60),2);

                $displayminutes = intdiv($seconds,60);
                $displayseconds = $seconds % 60;

                if ($displayseconds < 10 ) {
                    $displayseconds = '0'.$displayseconds;
                }

?>
<td>{{$displayminutes}}:{{$displayseconds}}</td>
    <td><a href="">{{$song->findartist()}}</a></td>
    <td><a href="/music/album/{{$song->album->id}}">{{$song->album->name}}</a></td>
<td>{{$song->track}}</td>
<td>{{$song->spotifyplays()}}</td>
</tr>




@endforeach
</table>
</div>        

@endsection