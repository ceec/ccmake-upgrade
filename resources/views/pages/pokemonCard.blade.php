@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<style>
    .card-image {
        width: 70%;
    }

.step-container {
	padding-top: 10px;
	padding-bottom: 5px;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            @if ($card->set_id == 98 || $card->set_id == 109 || $card->set_id == 118 || $card->set_id == 119 || $card->set_id > 120)
                <img class="card-image" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.png"><br>
            @else
                <img class="card-image" src="/images/pokemon/{{$set->url}}/{{$card->set_number}}.jpg"><br>
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{$card->name}}</h2>
            Set: <a href="/pokemon/set/{{$set->url}}/#{{$card->id}}">{{$set->name}}</a><br><br>
            <hr>
            tcgcsv Id: <a href="https://www.tcgplayer.com/product/{{$card->tcgcsv_id}}?Language=English">{{$card->tcgcsv_id}}</a><br>
            Latest Price: {{$card->lastPrice()}}<br>
            Price history:<br>
            @foreach($prices as $price)
                {{$price->created_at}} - ${{$price->price}}<br>
            @endforeach
            
            @if (!Auth::guest())
                @if (Auth::user()->id == 1)
                    <br><a href="/dashboard/pokemoncard/edit/{{$card->id}}">Edit Card</a><br><br>
                    @foreach ($usercards as $usercard)
                    <hr>
                    <form method="POST" action="/edit/pokemonusercard">
                        @csrf
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" value="{{$usercard->price}}" />
                        </div>   
                        <div class="form-group">
                            <label for="source">Source</label>
                            <input type="text" name="source" value="{{$usercard->source}}" />
                        </div> 
                        <div class="form-group">
                            <label for="date_acquired">Date</label>
                            <input type="text" name="date_acquired" value="{{$usercard->date_acquired}}" />
                        </div>  
                        <input type="hidden" name="id" value="{{$usercard->id}}" />
                        <input type="hidden" name="set_url" value="{{$set->url}}" />
                        <input type="hidden" name="pokemoncard_id" value="{{$card->id}}" />
                        <br>
                        <button type="submit">
                            Update
                        </button>
                    </form>
                    @endforeach

                @endif
            @endif
        </div>
    </div>


</div>

@endsection