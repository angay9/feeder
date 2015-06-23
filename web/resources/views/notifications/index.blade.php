@extends('app')
@section('content')
	<div class="container">
		
		<div class="row">
			<div class="col-md-12">
				@include('partials.logs', ['logs'=> $notifications]);
			</div>
		</div>
	</div>
@stop