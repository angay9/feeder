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
		<div class="col-md-12 text-center">
			{!! $logs->render() !!}
		</div>
	@else
		<h3>No logs.</h3>
	@endif
</div>