@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<style>
    .card-image {
        width: 70%;
    }

.step-container {
	padding-top: 10px;
	padding-bottom: 5px;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            @if ( $card->card_number == 1 )
                <img class="card-image" src="/images/onepiece/{{$set->shortname}}/{{$set->imagenumber()}}-{{$card->set_number}}.png"><br>
            @elseif ( $card->original_set_id != 0 )
                <img class="card-image" src="/images/onepiece/{{$originalset->shortname}}/{{$originalset->imagename}}-{{$card->original_set_number}}-{{$card->card_number}}.png"><br>
            @else
                <img class="card-image" src="/images/onepiece/{{$set->shortname}}/{{$set->imagenumber()}}-{{$card->set_number}}-{{$card->card_number}}.png"><br>
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{$card->name}}</h2>
            Set: <a href="/onepiece/set/{{$set->url}}/#{{$card->id}}">{{$set->name}}</a><br><br>
            <hr>
            tcgcsv Id: <a href="https://www.tcgplayer.com/product/{{$card->tcgcsv_id}}?Language=English">{{$card->tcgcsv_id}}</a><br>
            Latest Price: {{$card->lastPrice()}}<br>
            <style>
                #chartdiv {
                width: 100%;
                height: 300px;
                max-width: 100%;
                }
            </style>
            <!-- Resources -->
            <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
            <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
            <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
            <!-- Chart code -->
            <script>
            am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
            am5themes_Animated.new(root)
            ]);

            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX:true,
            paddingLeft: 0
            }));

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "none"
            }));
            cursor.lineY.set("visible", false);


            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            maxDeviation: 0.2,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {
                minorGridEnabled:true
            }),
            tooltip: am5.Tooltip.new(root, {})
            }));

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {
                pan:"zoom"
            }),
            tooltip: am5.Tooltip.new(root, {})
            }));


            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            var series = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
            }));


            var test = [];
            @foreach($prices as $price)
                test.push({"date":"{{$price->created_at}}","value":{{$price->price}}});
            @endforeach

            // Creating processor only for the first series
            series.data.processor = am5.DataProcessor.new(root, {
                dateFields: ["date"],
            dateFormat: "yyyy-MM-dd H:m:s"
            });

            series.bullets.push(function() {
            return am5.Bullet.new(root, {
            sprite: am5.Circle.new(root, {
                radius: 3,
                fill: series.get("fill")
            })
            });
        });

            series.data.setAll(test);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear(1000);
            chart.appear(1000, 100);

            }); // end am5.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>
            @if (!Auth::guest())
                <br><a href="/dashboard/onepiececard/edit/{{$card->id}}">Edit Card</a><br><br>
                @if (Auth::user()->id == 1)
                    @foreach ($usercards as $usercard)
                    <hr>
                    <form method="POST" action="/edit/onepieceusercard">
                        @csrf
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" value="{{$usercard->price}}" />
                        </div>   
                        <div class="form-group">
                            <label for="source">Source</label>
                            <input type="text" name="source" value="{{$usercard->source}}" />
                        </div> 
                        <div class="form-group">
                            <label for="date_acquired">Date</label>
                            <input type="text" name="date_acquired" value="{{$usercard->date_acquired}}" />
                        </div>  
                        <input type="hidden" name="id" value="{{$usercard->id}}" />
                        <input type="hidden" name="set_url" value="{{$set->url}}" />
                        <input type="hidden" name="onepiececard_id" value="{{$card->id}}" />
                        <br>
                        <button type="submit">
                            Update
                        </button>
                    </form>
                    @endforeach

                @endif
            @endif
        </div>
    </div>


</div>

@endsection