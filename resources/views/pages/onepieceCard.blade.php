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
            @if ( $card->card_number == 1)
                <img class="card-image" src="/images/onepiece/{{$set->url}}/{{$set->imagenumber()}}-{{$card->set_number}}.png"><br>
            @else
                <img class="card-image" src="/images/onepiece/{{$set->url}}/{{$set->imagenumber()}}-{{$card->set_number}}-{{$card->card_number}}.png"><br>
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{$card->name}}</h2>
            Set: <a href="/onepiece/set/{{$set->url}}">{{$set->name}}</a><br><br>
            @if (!Auth::guest())
                @if (Auth::user()->id == 1)
                    @foreach ($usercards as $usercard)
                    <hr>
                    <form method="POST" action="/edit/onepieceusercard">
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
                        <input type="hidden" name="onepiececard_id" value="{{$card->id}}" />
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