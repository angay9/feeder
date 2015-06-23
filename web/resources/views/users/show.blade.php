@extends('app')
@section('content')
	<div class="container">
		<h3> Profile: {{ $user->name }}</h3>
		<div class="row">
			<div class="col-md-10">
				{!! Form::open(['url' => '/users/save']) !!}
					<input type="hidden" name="id" value="{{ $user->id }}">
					<div class="form-group">
						<label for="" class="control-label">Name</label>
						{!! Form::text('name', $user->name, [
								'disabled'	=>	'disabled',
								'class'		=>	'form-control',
							])
						!!}
					</div>
					<div class="form-group">
						<label for="" class="control-label">Email</label>
						{!! Form::text('email', $user->email, [
								'disabled'	=>	'disabled',
								'class'		=>	'form-control',
							])
						!!}
					</div>
					<div class="form-group">
						<label for="" class="control-label">Device guid</label>
						@foreach ($user->devices as $device)
							{!! Form::text('device', $device->guid, [
									'disabled'	=>	'disabled',
									'class'		=>	'form-control',
								])
							!!}
						@endforeach
					</div>
					<div class="form-group">
						<div class="row">
							@if ($user->services->count() > 0)
								<div class="col-md-12">
									<h3>User requested these services:</h3>
								</div>
								@foreach($user->services as $service)
									<div class="col-sm-3">
										<label>

											{!! Form::checkbox('services[]', $service->id, $user->isServiceActive($service->id))
											!!}
											{{ $service->name . ' | ' . $service->feed }}
										</label>
									</div>
								@endforeach
							@else
								<div class="col-md-8">
									<h3>User didn't try to purchase any service yet</h3>
								</div>
							@endif
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-success">Save</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
		<div class="row">
			@include('partials.logs', ['logs'=> $logs])
		</div>
	</div>
@stop