@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Add New Pokemon Card</h1>
    
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
      <form method="POST" action="/add/pokemoncard">
        @csrf
            <div class="form-group">
              <label for="project">Set</label>
              <select name="set_id">
                @foreach ($sets as $id => $name)
                    <option value="{{ $id }}" @selected($id == $lastset)>
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
                />
            </div>   
            <div class="form-group">
              <label for="completed-at">Set Number</label>
              <input
                  type="text"
                  name="set_number"
                  value="{{$nextcard}}"
                />
            </div>                                                                               
            <button type="submit">
            Add
            </button>
        </form>
			
    	</div>
   	</div>

</div>


@endsection
