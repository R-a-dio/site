@section("content")

	<div class="container main">
		<h1 class="text-center">Last Played</h1>

		<ul class="list-group col-md-8 col-md-offset-2">
			@foreach ($lastplayed as $lp)
				<li class="list-group-item">
					<span>{{{ date("H:m:i", $lp["time"]) }}}</span>
					<span style="padding-left: 25px">{{{ $lp["meta"] }}}</span>
				</li>
			@endforeach
		</ul>
		

		<div class="text-center">
			{{ $lastplayed->links() }}
		</div>
	</div>

@stop
