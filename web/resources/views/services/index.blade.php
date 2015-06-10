@extends('app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="pull-right">
					{!! Form::open(['url' => url('/services/index'), 'class' => 'form-inline', 'method' => 'GET']) !!}
						<div class="form-group">
							<label class="control-label">Filter field</label>
							<select name="filterField" required class="form-control">
								<option value="name">name</option>
								<option value="feed">feed</option>
								<option value="price">price</option>
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
				@if ($services->total() > 0)
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
									Feed
									<div class="pull-right order-controls-container">
										<a href="?orderField=feed&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=feed&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th>
									Price
									<div class="pull-right order-controls-container">
										<a href="?orderField=price&orderDir=asc">
											<i class="fa fa-sort-asc"></i>
										</a>
										<a href="?orderField=price&orderDir=desc">
											<i class="fa fa-sort-desc"></i>
										</a>
									</div>
								</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($services as $service)
								<tr>
									<td>{{ $service->id }}</td>
									<td>{{ $service->name }}</td>
									<td>{{ $service->feed }}</td>
									<td>{{ $service->price }}</td>
									<td class="text-center">
										<a href="/services/edit/{{ $service->id }}" class="btn btn-success"><i class="fa fa-pencil"></i> Edit</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<h3>No data</h3>
				@endif
				<div class="text-center">
					{!! $services->render() !!}
				</div>
			</div>
		</div>
	</div>
@stop