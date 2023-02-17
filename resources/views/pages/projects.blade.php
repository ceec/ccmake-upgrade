@extends('structure.template')

@section('title')
@parent
ccmakesthings
@stop

@section('content')
<style>
    .cosplay {
        background-color: #e2aef2;
    }

    .programming {
        background-color: #afd2ff;
    }

    .step-container {
        padding-top: 10px;
        padding-bottom: 5px;
    }

    .col-md-12 {
        
    }
</style>
<div class="container">
    <h2>Projects</h2>
	<div class="row">
		<?php $x=1; ?>
		
        @foreach ($projects as $project)
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><a href="/project/{{$project->url}}">{{$project->name}}</a></h5>
                        
                    <p class="card-text">{{$project->recentStep[0]->name}}</p>
                    <span>{{date('F j, Y g:i a',strtotime($project->lastUpdated))}}</span>
            
                    </div>
                </div>
            </div>			
      <?php
        if ($x%4==0) {
			?>
				</div>
				<br>
				<div class="row">
			<?php                            
				}
				$x++;
			?>			
			@endforeach
			</div>
		<h2>Websites</h2>
		<ul>
			<li><a href="https://enstars.info">enstars.info</a></li>
			<li><a href="https://figurerant.com">figurerant.com</a></li>
		</ul>
</div>

@endsection