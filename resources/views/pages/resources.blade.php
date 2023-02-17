@extends('structure.template')

@section('title')
@parent
resources - ccmakesthings
@stop

@section('content')
<div class="container">
    <h1>Resources</h1>
    <ul>
    @foreach($resources as $resource)
      <li><a href="{{$resource->url}}">{{$resource->title}}</a></li>
    @endforeach
    </ul>
    <h2>Cosplay</h2>
      <ul>
        <li>Book - Guide to Basic Garment Assembly for the Fashion Industry</li>
        <li>Book - Sewing for Dummies, 3rd Edition</li>
        <li>Book - The Book of Prop Making</li>
        <li>Book - A Beginner’s Guide to Making Mind Blowing Props</li>
        <li>Book - Foamsmith: How to Create Foam Armor Costumes</li>
        <li>Book - The Mood Guide to Fabric and Fashion: The Essential Guide from the World's Most Famous Fabric Store</li>
        <li>Book - The Book of Cosplay Armor Making</li>
        <li>Book - The Book of Cosplay Sewing</li>
        <li>Book - The Hero's Closet: Sewing for Cosplay and Costuming</li>
        <li>Book - Make: Props and Costume Armor</li>
        <li>Book - Foamsmith 2: How to Forge Foam Weapons</li>
        <li>Book - Getting Started with 3D Printing</li>
        <li>Book - Make: Design for 3D Printing</li>
        <li>Book - Make: Design for 3D Printing</li>
        <li>Book - Primer: Moldmaking</li>
        <li>Book - A Robot’s Guide To: Bondo</li>
        <li>Book - The Book of Cosplay Lights</li>
        <li>Book - Make: Wearable Electronics: Design, Prototype, and Wear Your Own Interactive Garments</li>
        <li>Book - The Book of Cosplay Painting</li>
      </ul>
	</div>

@endsection