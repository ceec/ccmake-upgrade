@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Add New One Piece Card</h1>
    
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
      <form method="POST" action="/add/onepiececard">
        @csrf
            <div class="form-group">
              <label for="project">Set</label>
              <select name="set_id">
                @foreach ($sets as $id => $name)
                    <option value="{{ $id }}">
                        {{ $name }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="character">Character</label>
              <select name="character_id">
                @foreach ($characters as $id => $name)
                    <option value="{{ $id }}">
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
                  placeholder="001"
                />
            </div>                           
            <div class="form-group">
              <label for="name">Card Number</label>
              <input
                  type="text"
                  name="card_number"
                />
            </div>                   
            <div class="form-group">
              <label for="content">Original Set</label>
              <select name="original_set_id">
                  <option value="0">This one</option>
                @foreach ($sets as $id => $name)
                    <option value="{{ $id }}">
                        {{ $name }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="original-set-number">Original Set Number</label>
              <input
                  type="text"
                  name="original_set_number"
                  value="0"
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
