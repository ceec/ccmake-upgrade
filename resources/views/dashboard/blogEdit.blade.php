@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Editing {{$blog->title}}</h1>
    

    <div class="row">
    	<div class="col-md-12">
      <form method="POST" action="/edit/blog">
      @csrf
            <div class="form-group">
              <label for="project">Project</label>
              <select name="project_id">
                @foreach ($projects as $id => $name)
                    <option value="{{ $id }}" @selected($id == $blog->project_id)>
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
                  value={{$blog->started_at}}
                />
            </div>   
            <div class="form-group">
              <label for="completed-at">Completed At</label>
              <input
                  type="text"
                  name="completed_at"
                  value={{$blog->completed_at}}
                />
            </div>  
            <div class="form-group">
              <label for="name">Name</label>
              <input
                  type="text"
                  name="name"
                  value={{$blog->name}}
                />
            </div>                  
            <div class="form-group">
              <label for="text">Text</label>
              <input
                  type="textarea"
                  name="text"
                  value={{$blog->text}}
                />
            </div>    
            <input
                  type="hidden"
                  name="blog_id"
                  value={{$blog->id}}
                />  
                <button type="submit">
            Edit
            </button>
            </form>
    	</div>
   	</div>

</div>


@endsection
