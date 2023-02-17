@extends('structure.template')

@section('title')
@parent
time - ccmakesthings
@stop

@section('content')
<style>
    .table {
        font-size: 25px;
    }
</style>
<div class="container">
    <h2>Time</h2>
    <table class="table">
        <tr>
            <td>Denver</td>
            <td>
            <?php 
			date_default_timezone_set('America/Denver');
			print date('g:ia');
?>	
            </td>
            <td>
                <?php print date('l'); ?>
            </td>
            <td>
                <?php print date('F d, Y'); ?>
            </td>
        </tr>
        <tr>
            <td>Vilnius</td>
            <td>
            <?php 
          date_default_timezone_set('Europe/Vilnius');
          print date('g:ia');
?>	
            </td>
            <td>
            <?php print date('l'); ?>
            </td>
            <td>
            <?php print date('F d, Y'); ?>
            </td>
        </tr>
        <tr>
            <td>Tokyo</td>
            <td>
            <?php 
          date_default_timezone_set('Asia/Tokyo');
          print date('g:ia');
?>	
            </td>
            <td>
            <?php print date('l'); ?>
            </td>
            <td>
            <?php print date('F d, Y'); ?>
            </td>
        </tr>
    </table>

</div>


@endsection