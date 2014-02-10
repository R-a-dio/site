@section("content")

	<div class="container main">
		<h1 class="text-center">Queue</h1>

		<ul class="list-group col-md-8 col-md-offset-2">
			@foreach ($queue as $q)
				@if ($q["type"] > 0)
					<li class="list-group-item list-group-item-success">
				@else
					<li class="list-group-item">
				@endif
					<span>{{{ date("H:m:i", $q["time"]) }}}</span>
					<span style="padding-left: 25px">{{{ $q["meta"] }}}</span>
				</li>
			@endforeach
		</ul>
		

		<div class="text-center">
			{{ $queue->links() }}
		</div>
	</div>

@stop
