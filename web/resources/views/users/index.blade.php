@extends('app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="pull-right">
					{!! Form::open(['url' => url('/users/index'), 'class' => 'form-inline', 'method' => 'GET']) !!}
						<div class="form-group">
							<label class="control-label">Filter field</label>
							<select name="filterField" required class="form-control">
								<option value="name">name</option>
								<option value="email">email</option>
							</select>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Filter value</label>
							<input type="text" class="form-control" name="filterValue" placeholder="Search...">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Search</button>
						</div>
					{!! Form::close() !!}
					<br>
				</div>
				@if ($users->total() > 0)
					<table class="table table-bordered table-hover table-striped">
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
									Name
									<div class="pull-right order-controls-container">
										<a href="?orderField=name&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=name&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th>
									Email
									<div class="pull-right order-controls-container">
										<a href="?orderField=email&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=email&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th>
									Registration Date
									<div class="pull-right order-controls-container">
										<a href="?orderField=created_at&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=created_at&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th>
									Devices guid
								</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
								<tr>
									<td>{{ $user->id }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->created_at }}</td>
									<td>
										@foreach ($user->devices as $device)
											<span>{{ $device->guid }}</span>
											<br>
										@endforeach
									</td>
									<th>
										<a href="/users/show/{{ $user->id }}" class="btn btn-success">
											<i class="fa fa-search"> Show</i> 
										</a>
									</th>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<h3>No data</h3>
				@endif
				<div class="text-center">
					{!! $users->render() !!}
				</div>
			</div>
		</div>
	</div>
@stop