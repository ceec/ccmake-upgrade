@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<div class="container">
<h2>Music</h2>
<div class="row">
    <div class="col-md-6">
        <h3>Last 10 played</h3>
        <table class="table">
		<thead>
			<tr>
            <td>Name</td>
			<td>Artist</td>
            <td>Date</td>
			</tr>
		</thead>
        @foreach($lastten as $song)
            <tr>
                <td>{{$song->songName()}}</td>
                <td><a href="">{{$song->findartist()}}</a></td>
                <td>{{$song->played_at}}</td>
            </tr>
        @endforeach
        </table>
    </div>
    <div class="col-md-6">
        <h3>New listens</h3>
		<table class="table">
		<thead>
			<tr>
            <td>Name</td>
			<td>Artist</td>
            <td>Date</td>
			</tr>
		</thead>
        @foreach($newsongs as $song)
            <tr>
                <td>{{$song->name}}</td>
                <td><a href="">{{$song->findartist()}}</a></td>
                <td>{{$song->created_at}}</td>
            </tr>
        @endforeach
        </table>
    </div>
</div>

<h3>Top All time</h3>
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
        @foreach($mostplays as $id => $song)
<tr>
    <td>{{$song[0]->name}}</td>
    <?php //gross formatting of miliseconds
                $milliseconds = $song[0]->length;
                $seconds = floor($milliseconds/1000);
                $minutes = round(floor($seconds/60),2);

                $displayminutes = intdiv($seconds,60);
                $displayseconds = $seconds % 60;

                if ($displayseconds < 10 ) {
                    $displayseconds = '0'.$displayseconds;
                }

?>
<td>{{$displayminutes}}:{{$displayseconds}}</td>
    <td><a href="">{{$song[0]->findartist()}}</a></td>
    <td><a href="/music/album/{{$song[0]->album->id}}">{{$song[0]->album->name}}</a></td>
<td>{{$song[0]->track}}</td>
<td>{{$song['count']}}</td>
</tr>
@endforeach
</table>
</div>   



@endsection