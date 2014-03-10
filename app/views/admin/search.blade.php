@section("content")

	<div class="container main">
		<h1>Elasticsearch Management</h1>

		<div class="row">
			<div class="col-md-4">
				{{ Form::open(["method" => "put"]) }}
					<button type="submit" class="btn btn-block btn-success">Rebuild Index</button>
				{{ Form::close() }}
				
			</div>
			<div class="col-md-4">
				<button class="btn btn-block btn-info">Query Index</button>
			</div>
			<div class="col-md-4">
				<button class="btn btn-block btn-danger">Purge Index</button>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-12">
				@if (isset($index))
					{{ var_dump($index) }}
				@endif
			</div>
		</div>
	</div>

@stop
