@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Add New Blog Post</h1>
    
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
      <form method="POST" action="/add/blog">
        @csrf

            <div class="form-group">
              <label for="project">Project</label>
              <select name="project_id">
                @foreach ($projects as $id => $name)
                    <option value="{{ $id }}" @selected(old('id') == $id)>
                        {{ $name }}
                    </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="started-at">Started At</label>
                <input
                  type="text"
                  name="started_at"
                />
            </div>   
            <div class="form-group">
              <label for="completed-at">Completed At</label>
              <input
                  type="text"
                  name="completed_at"
                />
            </div>                           
            <div class="form-group">
              <label for="name">Title</label>
              <input
                  type="text"
                  name="name"
                />
            </div>                            
            <div class="form-group">
              <label for="content">Content</label>
                            <input
                  type="textarea"
                  name="text"
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
