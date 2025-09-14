@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Edit One Piece Character</h1>
    
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
      <form method="POST" action="/edit/onepiececharacter">
        @csrf
            <div class="form-group">
              <label for="name">Name</label>
                <input
                  type="text"
                  name="name"
                  value="{{$character->name}}"
                />
            </div>                          
            <input
                  type="hidden"
                  name="character_id"
                  value={{$character->id}}
                />                                                    
            <button type="submit">
            Edit
            </button>
        </form>
			
    	</div>
   	</div>

</div>


@endsection
