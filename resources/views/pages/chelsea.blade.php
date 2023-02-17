@extends('structure.template')

@section('title')
@parent
chelsea - ccmakesthings
@stop

@section('content')
    <style>
        .padding{
            padding-left: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .volume {
            background-color: lightgray;
        }
    </style>

    <div class="container">
        <input type="text" placeholder="Search" id="search">
        <br><br>
        @foreach($volumes as $volume)
            <div class="row volume">
                    <div class="col">
                        <img class="img-fluid" src="/images/chelsea/doujin/{{$volume->id}}.jpg">
                    </div>
                    <div class="col padding">
                        {{$volume->title_j}} {{$volume->title_e	}}<hr>
                        {{$volume->pairing->name}}
                    </div>
                </div>
            <br>    
        @endforeach
    </div>

@endsection