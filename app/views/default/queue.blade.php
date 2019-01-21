@section("content")

	<div class="container main content">
		<h1 class="text-center">Queue</h1>

		<ul class="time-list list-group col-md-8 col-md-offset-2">
			@foreach ($queue as $q)
				@if ($q["type"] > 0)
					<li class="list-group-item list-group-item-info">
				@else
					<li class="list-group-item">
				@endif
					<time datetime="{{{ date(DATE_ISO8601, $q["time"]) }}}">{{{ date("H:i:s", $q["time"]) }}}</time>
					<span>{{{ $q["meta"] }}}</span>
				</li>
			@endforeach
		</ul>
	</div>

@stop
