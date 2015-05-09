@extends('app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				{!! Form::model($service, ['url' => 'services/update', 'method' => 'post']) !!}
					<div class="form-group">
						<label for="" class="control-label">Name</label>
						{!! Form::text('name', null, [
								'disabled'	=>	'disabled',
								'class'		=>	'form-control'
							]) 
						!!}
						<input type="hidden" name="id" value="{{ $service->id }}">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Feed</label>
						{!! Form::text('feed', null, [
								'disabled'	=>	'disabled',
								'class'		=>	'form-control'
							]) 
						!!}
					</div>
					<div class="form-group">
						<label for="" class="control-label">Price</label>
						{!! Form::text('price', null, [
								'class'		=>	'form-control',
								'pattern'	=>	'^\d+(\.\d+)*$'
							]) 
						!!}
					</div>
					<div class="form-group">
						<button class="btn btn-success">Save</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop