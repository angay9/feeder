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
			<div class="col-md-12">
				@if ($logs->total() > 0)
					<table class="table table-bordered table-hover table-stripped">
						<thead>
							<tr>
								<th>
									Id
									<div class="pull-right order-controls-container">
										<a href="?orderField=id&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=id&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th>
									Log
									<div class="pull-right order-controls-container">
										<a href="?orderField=log&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=log&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th>
									Extra info
									<div class="pull-right order-controls-container">
										<a href="?orderField=info&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=info&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th>
									Date
									<div class="pull-right order-controls-container">
										<a href="?orderField=updated_at&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=updated_at&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($logs as $log)
								<tr>
									<td>{{ $log->id }}</td>
									<td>{{ $log->getHumanLogName() }}</td>
									<td>{{ $log->info }}</td>
									<td>{{ $log->updated_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<h3>User doesn't have any history yet.</h3>
				@endif
			</div>
			<div class="col-md-12 text-center">
				{!! $logs->render() !!}
			</div>
		</div>
	</div>
@stop