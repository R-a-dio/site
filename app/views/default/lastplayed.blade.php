@section("content")

	<div class="container main content">
		<h1 class="text-center">Last Played</h1>

		<ul class="time-list list-group col-md-8 col-md-offset-2 col-xs-12">
			@foreach ($lastplayed as $lp)
				<li class="list-group-item">
					<time datetime="{{{ date(DATE_ISO8601, $lp["time"]) }}}">{{{ date($lp["time"] < strtotime('today') ? "Y-m-d H:i:s" : "H:i:s", $lp["time"]) }}}</time>
					<span>{{{ $lp["meta"] }}}</span>
				</li>
			@endforeach
		</ul>
		

		<div class="text-center">
			{{ $lastplayed->links() }}
		</div>
	</div>

@stop
