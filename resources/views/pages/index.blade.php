@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<style>
.ccmake-cosplay {
	background-color: #e2aef2;
}

.ccmake-programming {
	background-color: #afd2ff;
}

.step-container {
	padding-top: 10px;
	padding-bottom: 5px;
}
</style>
	<div class="container">
		@if(isset($project))
			<div id="project-grid"></div>
			<br>
			<!-- display grid for that project -->
			<script>
				var projectID = {{$project->id}};
			</script>

			<script src="https://d3js.org/d3.v4.min.js"></script>
			<script>
			var width = 960,
					height = 136,
					cellSize = 17;

			var color = d3.scaleQuantize()
					.domain([200, 219])
					.range(["#7cf170"]);
				
			//this one goes backwards 2017 to 2000
			//http://bl.ocks.org/eesur/5fbda7f410d31da35e42

			var svg = d3.select("#project-grid")
				.selectAll("svg")
				.data(d3.range(2019, 2020))
				.enter().append("svg")
					.attr("width", width)
					.attr("height", height)
				.append("g")
					.attr("transform", "translate(" + ((width - cellSize * 53) / 2) + "," + (height - cellSize * 7 - 1) + ")");

			svg.append("text")
					.attr("transform", "translate(-20," + cellSize * 3.5 + ")rotate(-90)")
					.attr("font-family", "sans-serif")
					.attr("font-size", 10)
					.attr("text-anchor", "middle")
					.text(function(d) { return d; });
			svg.append("text")
					.attr("transform", "translate(-8,28)rotate(0)")
					.attr("font-family", "sans-serif")
					.attr("font-size", 10)
					.attr("text-anchor", "middle")
					.text("M");

			svg.append("text")
					.attr("transform", "translate(-8,64)rotate(0)")
					.attr("font-family", "sans-serif")
					.attr("font-size", 10)
					.attr("text-anchor", "middle")
					.text("W");

			svg.append("text")
					.attr("transform", "translate(-8,98)rotate(0)")
					.attr("font-family", "sans-serif")
					.attr("font-size", 10)
					.attr("text-anchor", "middle")
					.text("F");					

			//drawing the grid
			var rect = svg.append("g")
					.attr("fill", "none")
					.attr("stroke", "#ccc")
				.selectAll("rect")
				.data(function(d) { return d3.timeDays(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
				.enter().append("rect")
					.attr("width", cellSize)
					.attr("height", cellSize)
					.attr("x", function(d) { return d3.timeWeek.count(d3.timeYear(d), d) * cellSize; })
					.attr("y", function(d) { return d.getDay() * cellSize; })
					.datum(d3.timeFormat("%Y-%m-%d"));

					//drawing the lines around the months
			svg.append("g")
					.attr("fill", "none")
					.attr("stroke", "#000")
				.selectAll("path")
				.data(function(d) { return d3.timeMonths(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
				.enter().append("path")
					.attr("d", pathMonth);


			//load from JSON instead of CSV - 2017-08-08
			d3.json("/data/grid/"+projectID, function(error,json) {
				if (error) throw error;

				var data = d3.nest()
						.key(function(d) { return d.updated; })
						.rollup(function(d) { 

							console.log(d);
							return d[0].id; })
					.object(json);


				rect.filter(function(d) { return d in data; })
						//.attr("fill", "#a50026")
								.attr("fill", function(d) { 
									//change the color based on the data[d] -> document id
									return color(data[d]); })
					.append("title")
						.text(function(d) { 
							return d + ": " + data[d]; });

			});



			function pathMonth(t0) {
				var t1 = new Date(t0.getFullYear(), t0.getMonth() + 1, 0),
						d0 = t0.getDay(), w0 = d3.timeWeek.count(d3.timeYear(t0), t0),
						d1 = t1.getDay(), w1 = d3.timeWeek.count(d3.timeYear(t1), t1);
				return "M" + (w0 + 1) * cellSize + "," + d0 * cellSize
						+ "H" + w0 * cellSize + "V" + 7 * cellSize
						+ "H" + w1 * cellSize + "V" + (d1 + 1) * cellSize
						+ "H" + (w1 + 1) * cellSize + "V" + 0
						+ "H" + (w0 + 1) * cellSize + "Z";
			}
					
			</script>
		@endif
	@foreach($steps as $step)
		<div class="ccmake-{{strtolower($step->project->category->name)}} col-md-12 step-container">
		{{ date('F j, Y', strtotime($step->started_at)) }}<br>
			<h2><a href="/category/{{$step->project->category->url}}">{{$step->project->category->name}}</a> - <a href="/project/{{$step->project->url}}"> {{$step->project->name}}</a></h2>
			<h2>{{$step->name}}</h2>
			@if($step->project_id == 8)
			<div class="row">
				<div class="col-3">
					Theater: 
				</div>
				<div class="col-3">
					Rating:
				</div>
			</div>
			@endif			
			<div class="row">
				<div class="col-3">
					@if(!($step->tags)->isEmpty())
						<i class="fa fa-folder-o" aria-hidden="true"></i>
						Tags: 
						@foreach($step->tags as $key => $tag)
						    @if( count( $step->tags ) != $key + 1 )
						        <a href="/tag/{{strtolower($tag->tag->name)}}">{{$tag->tag->name}}</a>,
						     @else
						        <a href="/tag/{{strtolower($tag->tag->name)}}">{{$tag->tag->name}}</a>
						    @endif
						@endforeach
					@endif


					
				</div>
				<div class="col-3">
					@if(!($step->tools)->isEmpty())
						<i class="fa fa-wrench" aria-hidden="true"></i>
						Tools: 
						@foreach($step->tools as $key => $tool)
						    @if( count( $step->tools ) != $key + 1 )
						        <a href="/tool/{{strtolower($tool->tool->url)}}">{{$tool->tool->name}}</a>,
						     @else
						        <a href="/tool/{{strtolower($tool->tool->url)}}">{{$tool->tool->name}}</a>
						    @endif
						@endforeach
					@endif
				</div>
			</div>
			
			<p>{!! $step->text !!}</p>
			@if(isset($step->completed_at))
			<?php
				//figure out how long 
				
				//start
				$start = new DateTime($step->started_at);
				$end = new DateTime($step->completed_at);
				$time_spent = $start->diff($end);

				//create a function to format this
				$time_display = '';
				if ($time_spent->y > 0) {
					$time_display .= $time_spent->y." years ";
				}

				if ($time_spent->m > 0) {
					$time_display .= $time_spent->m." months ";
				}

				if ($time_spent->d > 0) {
					$time_display .= $time_spent->d." days ";
				}

				if ($time_spent->h > 0) {
					$time_display .= $time_spent->h." hours ";
				}	

				if ($time_spent->i > 0) {
					$time_display .= $time_spent->i." minutes ";
				}								
			?>
			<div class="row">
				<div class="col-3">
					<strong><i class="fa fa-clock-o" aria-hidden="true"></i> Time Spent: {{$time_display}}</strong> 
				</div>
				<div class="col-3">
					
				</div>
			</div>
			@endif
		</div>
		<br><br>


	@endforeach

	</div>

@endsection