@extends('structure.template')

@section('title')
@parent
counties - ccmakesthings
@stop

@section('content')
<style>
        .counties {
      fill: none;
    }
    
    .counties :hover {
  fill: red;
}
    
    .states {
      fill: none;
      stroke: #000;
      stroke-linejoin: round;
    }
</style>
	<div class="container">
        <h4>Counties</h4>
        <svg width="960" height="600"></svg>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
<script src="https://d3js.org/topojson.v2.min.js"></script>
<script>
    var svg = d3.select("svg"),
        width = +svg.attr("width"),
        height = +svg.attr("height");
    
    var visited = d3.map();
    
    var path = d3.geoPath();
    
        //does change the color of the map
    var color = d3.scaleThreshold()
        .domain(d3.range(2, 10))
        .range(d3.schemeBlues[9]);
    
     var test = d3.map();
    
    d3.queue()
        .defer(d3.json, "https://d3js.org/us-10m.v1.json")

        ///loading from json does not work for some reason, go read .json docs I guess!


   .defer(function(url, callback) {
        d3.json(url, function(error, d) {
            // Limit GeoJSON features to those in CSV
        for (var i = 0; i < d.length; i++) {
            visited.set(d[i].code,d[i].county);
        };
            callback(error, d);
        })
    }, "/data/counties")

       // .defer(d3.json, "/data/counties", function(d) { 
       //  console.log('here?');
       //      // console.log('here');
       //      //          for (var i = 0; i < d.length; i++) {
       //      //             test.set(d[i].id,d[i].county);
       //      //             //var piece = {"id":d[i].id,"county":d[i].county}
       //      //             //test.push(piece);
       //      //         };   

       //      //         console.log(test);
       //  for (var i = 0; i < d.length; i++) {
       //      visited.set(d[i].id,d[i].county);
       //  };
       //  console.log(visited);


       //.defer(d3.csv, "https://s3-us-west-2.amazonaws.com/s.cdpn.io/716619/unemployment_copy.csv", function(d) { 
        //visited.set(d.id,d.county); 
        
         //console.log(visited);
        //visited.set(d.id,d.country);
       
      // })
        .await(ready);
    
    function ready(error, us) {
      if (error) throw error;

      svg.append("g")
          .attr("class", "counties")
        .selectAll("path")
        .data(topojson.feature(us, us.objects.counties).features)
        .enter().append("path")
          .attr("fill", function(d) { 
            //console.log(d.id);
            //console.log('data: '+test.has("$"+d.id));
              if ((d.id == 36075) || (d.id == 08069) || (d.id == 36055) || (d.id == 08031) ) {
                return "red";//on condition match
             } else if (visited.has(d.id) ){
                return "#6699FF";
                } else {
                    return "gray";
                }
            })
          .attr("d", path)
        .append("title")
          .text(function(d) { 
            return visited.get(d.id); });
    
      svg.append("path")
          .datum(topojson.mesh(us, us.objects.states, function(a, b) { return a !== b; }))
          .attr("class", "states")
          .attr("d", path);
    }

    
</script>
  
	</div>

@endsection