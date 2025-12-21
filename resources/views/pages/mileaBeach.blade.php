@extends('structure.mileabeach')

@section('title')
@parent
mileabeach
@stop

@section('content')
<div class="container">
  <div class="col-md-12">
    <h1>Current Conditions</h1>
  <?php
  // Make a friendly Farenheight function
  // Move this to where it should actually go
  function convertToFarenheight($c) {

    $f = ((9/5) * $c) + 32;

    $f = round($f,2);

    return $f;
  }

  function convertPressure($pressure) {

    $pressure = $pressure / 100;

    $pressure = round($pressure,1);

    return $pressure;
  }



?>    
      <h2>Temp: {{convertToFarenheight($weather->air_temperature)}} &deg;F</h2>
      <h2>Temp: {{$weather->air_temperature}} &deg;C</h2>
      <h2>Humidity: {{$weather->relative_humidity}}%</h2>
      <h2>Pressure: {{$weather->barometric_pressure}} mb</h2>
      <h2>Average Wind: {{$weather->wind_avg}} mph {{$weather->wind_direction}}&deg; {{$weather->cardinal_direction}}
    
      <p><a href="https://tempestwx.com/station/19456/">Camp Station Forcast</a>
      <p><a href="https://tempestwx.com/station/19456/grid">Full Weather Details</a>
  </div>
</div>


@endsection