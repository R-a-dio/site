@section("content")

	<div class="container main">
		<h1 class="text-center">Queue</h1>
		@foreach ($queue as $q)
			<div class="row">
				<div class="col-sm-4 text-center">
					{{ time_ago($q["time"]) }}
				</div>
				<div class="col-sm-8 text-center">
					@if ($q["type"] > 0)
						<b>{{{ $q["meta"] }}}</b>
					@else
						{{{ $q["meta"] }}}
					@endif
				</div>
			</div>
		@endforeach

		<div class="text-center">
			{{ $queue->links() }}
		</div>
	</div>

@stop
