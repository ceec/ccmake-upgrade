@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<style>
    .manga-container {
        display: flex;
        flex-wrap: wrap;
    }
    .mangacheck {
        border: 2px solid darkgreen;
        margin: 5px;
        padding: 0px 15px;
    }

    .manga-have {
        background-color: green;
        color:lightgreen;
    }
</style>
<div class="container">
<h2>Manga</h2>
        
        @foreach($mangas as $manga)
            {{$manga->title}}<br>
            <div class="manga-container">
            @foreach ($manga->volumes()->get() as $volume)
                <div class="mangacheck 
                    @if ($volume->have == 1)
                    manga-have
                    @endif
                ">
                {{$volume->volume}}<br>
                </div>
            @endforeach
            </div>
        @endforeach

        <h2>Art Books</h2>

        @foreach($artbooks as $artbook)
            {{$artbook->title}}<br>
            <div class="manga-container">
            @foreach ($artbook->volumes()->get() as $volume)
                <div class="mangacheck 
                    @if ($volume->have == 1)
                    manga-have
                    @endif
                ">
                {{$volume->volume}}<br>
                </div>
            @endforeach
            </div>
        @endforeach
</div>        

@endsection