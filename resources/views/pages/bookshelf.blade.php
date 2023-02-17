@extends('structure.template')

@section('title')
@parent
bookshelf - ccmakesthings
@stop

@section('content')
<div class="container">
    <h3>Bookshelf</h3>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.5.0/d3.min.js"></script>
    <div id="bookshelf"></div>
    <script>
        //Make an SVG Container
        var svgContainer = d3.select("#bookshelf").append("svg")
                              .attr("xlink","http://www.w3.org/1999/xlink")
                              .attr("width", 1200)
                              .attr("height", 200);     

        var books = {'1':'Becoming Dangerous','2':'Pin Hell','3':'How to Read Water','4':'How to Read Water','5':'How to Read Water'};                  
        var bookjson = <?php print $bookjson; ?>;
    </script>
    
    <script>
      var x = 0;
      var textx = 0;
      for (const key in bookjson) {
        // if (books.hasOwnProperty(key)) {
        //   const element = books[key];
          
        // }
          //Draw the Rectangle
        var rectangle = svgContainer.append("rect")
                                    .attr("fill", 'white')
                                    .style("stroke", '#074886')
                                    .style("stroke-width", 2)
                                    .attr("x", x)
                                    .attr("y", 0)
                                    .attr("width", 40)
                                    .attr("height", 200);      
                                    x = x+40;        
      }

      var x = 30;
      var textx = 0;
for (const key in bookjson) {
  var title = bookjson[key]['title'];

  var length = title.length;
  var fontSize = 18;

  if (length > 20) {
    var difference = length - 20;

    fontSize = fontSize - (difference/2);

  }


  //add link to title
  //title = '<a xlink:href="test.com">'+title+'</a>';


        var text = svgContainer.append('text').text(title)
                        //.attr("x", textx+5)
                        .attr("x", x)
                        .attr("y", 0)
                        .style("stroke", '#074886')       
                        .attr("transform", "rotate(90 20 "+textx+")")               
                        .attr("font-size", fontSize)
                        .attr('fill', 'black');

                        textx = textx+40;    
                        x = x - 40;
}

    
    </script>

    @foreach($books as $book)
      {{$book->title}}<br>
    @endforeach
	</div>
@endsection