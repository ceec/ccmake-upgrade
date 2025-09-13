@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Add New One Piece Set</h1>
    
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
      <form method="POST" action="/add/onepieceset">
        @csrf
            <div class="form-group">
              <label for="name">Name</label>
                <input
                  type="text"
                  name="name"
                />
            </div>   
            <div class="form-group">
              <label for="url">Url</label>
              <input
                  type="text"
                  name="url"
                />
            </div>                           
            <div class="form-group">
              <label for="release-date">Release Date</label>
              <input
                  type="text"
                  name="release_date"
                />
            </div>                            
            <div class="form-group">
              <label for="content">Short Name</label>
                <input
                  type="text"
                  name="shortname"
                />
            </div>                 
            <div class="form-group">
              <label for="content">Image Name</label>
                <input
                  type="text"
                  name="imagename"
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
