@section("content")

<div class="container main">
	<div class="table-responsive">
		<table class="table">
			@foreach ($queue as $q)

				@if ($q["type"] == 1)
					<tr class="active">
				@else
					<tr>
				@endif

					<td>{{{ $q["meta"] }}}</td>
					<td>{{{ $q["time"] }}}</td>
					<td><i class="icon-heart"></i></td>
				</tr>

			@endforeach

		</table>
	</div>
</div>
@stop
