@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Edit <a href="/pokemon/set/{{$set->url}}/{{$card->id}}">{{$card->name}}</a></h1>
    
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row">
    	<div class="col-md-12">
      <form method="POST" action="/edit/pokemoncard">
        @csrf
            <div class="form-group">
              <label for="project">Set</label>
              <select name="set_id">
                @foreach ($sets as $id => $name)
                    <option value="{{ $id }}" @selected($id == $card->set_id)>
                        {{ $name }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="started-at">Name</label>
                <input
                  type="text"
                  name="name"
                  value="{{$card->name}}"
                />
            </div>      
            <div class="form-group">
              <label for="completed-at">Set Number</label>
              <input
                  type="text"
                  name="set_number"
                  value="{{$card->set_number}}"
                />
            </div>                           
            <div class="form-group">
              <label for="original-set-number">TCG csv id</label>
              <input
                  type="text"
                  name="tcgcsv_id"
                  value="{{$card->tcgcsv_id}}"
                />
            </div>         
            <input
                  type="hidden"
                  name="card_id"
                  value={{$card->id}}
                />                                
            <button type="submit">
            Edit
            </button>
        </form>
			
    	</div>
   	</div>

</div>


@endsection
