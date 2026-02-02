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
                    <option value="{{ $id }}" @selected($id == $lastset)>
                        {{ $name }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
            <div class="form-group">
              <label for="started-at">Name</label>
                <input
                  id="charactername"
                  type="text"
                  name="name"
                />
            </div>   
              <label for="character">Character</label>
              <select id="character-id" name="character_id">
                @foreach ($characters as $id => $name)
                    <option value="{{ $id }}">
                        {{ $name }}
                    </option>
                @endforeach
              </select>
            </div>            
            <div class="form-group">
              <label for="completed-at">Set Number</label>
              <input
                  type="text"
                  name="set_number"
                  value="{{$nextcard}}"
                />
            </div>                           
            <div class="form-group">
              <label for="name">Card Number</label>
              <input
                  type="text"
                  name="card_number"
                  value ="1"
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
            <div class="form-group">
              <label for="tcgcsv-id">tcgcsv id</label>
              <input
                  type="text"
                  name="tcgcsv_id"
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

<script>
$(document).ready(function() {
  $('#charactername').on('input', function() {
    // Get the pasted/typed value and trim whitespace
    var val = $(this).val().trim();
    // Ignore things after a parens if there is one
    const beforeParens = val.split(/(\()/g);
    const name = beforeParens[0].trim().toLowerCase();
    // Find the option that matches the text 
    $('#character-id option').filter(function() {
      return $(this).text().trim().toLowerCase() === name;
    }).prop('selected', true);
  });
});
  </script>
@endsection
