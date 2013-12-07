@section("content")
	<div class="container main">
	@foreach($staff as $i => $s)

		<div class="col-md-3">

			<div class="thumbnail" style="height: 221px">
				<img src="https://r-a-d.io/res/img/dj/{{ $s["djimage"] }}" alt="{{{ $s["djname"] }}}" height="150" width="150" style="max-height: 150px">
				<div class="text-center">
					{{{ $s["djname"] }}}
				</div>

				@if ($s["role"] == "dev")
					<p class="text-center text-info">
						Developer
					</p>
				@elseif ($s["role"] == "dj")
					<p class="text-center text-success">
						<a class="btn btn-info btn-xs">DJ - Follow</a>
					</p>
				@else
					<p class="text-center text-success">
						Staff
					</p>
				@endif

			</div>
		</div>

	@endforeach
	</div>
@stop
