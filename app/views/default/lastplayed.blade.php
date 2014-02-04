@section("content")

	<div class="container main">
		<h1 class="text-center">Last Played</h1>
		@foreach ($lastplayed as $lp)
			<div class="row">
				<div class="col-sm-4 text-center">
					{{ time_ago($lp["time"]) }}
				</div>
				<div class="col-sm-8 text-center">
					{{{ $lp["meta"] }}}
				</div>
			</div>
		@endforeach

		<div class="text-center">
			{{ $lastplayed->links() }}
		</div>
	</div>

@stop
