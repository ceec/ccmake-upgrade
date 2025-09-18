@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Edit Pokemon Set</h1>
    
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
      <form method="POST" action="/edit/pokemonset">
        @csrf
            <div class="form-group">
              <label for="name">Name</label>
                <input
                  type="text"
                  name="name"
                  value="{{$set->name}}"
                />
            </div>   
            <div class="form-group">
              <label for="url">Url</label>
              <input
                  type="text"
                  name="url"
                  value="{{$set->url}}"
                />
            </div>                           
            <div class="form-group">
              <label for="release-date">Release Date</label>
              <input
                  type="text"
                  name="release_date"
                  value="{{$set->release_date}}"
                />
            </div>                            
            <div class="form-group">
              <label for="content">Generation ID</label>
                <input
                  type="text"
                  name="generation_id"
                  value="{{$set->generation_id}}"
                />
            </div>                 
            <input
                  type="hidden"
                  name="set_id"
                  value={{$set->id}}
                />                                                    
            <button type="submit">
            Edit
            </button>
        </form>
			
    	</div>
   	</div>

</div>


@endsection
