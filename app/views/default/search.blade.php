@section('content')

<div class="container main">
	<!-- Search Bar -->
	<div class="container">
		<div class="col-md-7 centered">
			<h1 class="text-center text-info"> {{{ trans("search.help.main") }}} </h1>
			{{ Form::open(['url' => "/search", "class" => "ajax-search"]) }}
				<div class="input-group">
					<input type="text" class="form-control" placeholder="{{{ trans("search.placeholder") }}}" name="q" id="search" value="{{{ $param }}}">
					<div class="input-group-btn">
						<button class="btn btn-info" type="submit">
							{{{ trans("search.button") }}}
						</button>
					</div>
				</div>
			{{ Form::close() }}

		</div>
		<hr>
		<div class="col-md-7 centered">
			<h2 class="text-center text-warning"> {{{ trans("search.help.options") }}} </h2>
		</div>
	</div>

	@if ($search)
		<!-- Search Results -->
		<div class="container">

			<table class="table table-responsive">
				
				<thead>
					<th colspan="4">{{{ trans("search.metadata") }}}</th>
					<th>{{{ trans("search.plays") }}}</th>
					<th>{{{ trans("search.fave") }}}</th>
					<th>{{{ trans("search.request") }}}</th>
				</thead>
				<tbody>
					@foreach ($search["data"] as $result)

						<tr>

							@if ($result["cooldown"])
								<td colspan="4" class="cooldown" data-id="{{ $result["id"] }}">
							@else
								<td colspan="4" data-id="{{ $result["id"] }}">
							@endif
								<span class="text-danger">{{{ $result["track"] }}}</span> - <span class="text-info">{{{ $result["artist"] }}}</span>
							</td>
							<td>
								0
							</td>
							<td>
								<button class="btn btn-danger fave-button" data-id="{{ $result["id"] }}">
									<i class="fa fa-heart"></i>
								</button>
							</td>
							<td>
								@if ($result["cooldown"])
									<button class="btn btn-block btn-danger request-button disabled">
										{{{ trans("search.cooldown") }}}
									</a>
								@else
									<button class="btn btn-block btn-success request-button" href="/request/{{ $result["id"] }}">
										{{{ trans("search.requestable") }}}
									</a>
								@endif
							</td>
						</tr>

					@endforeach
				</tbody>
			
			</table>

			<div class="text-center">
				{{ $links }}
			</div>
			

		</div>
	@endif


</div>

@stop

@section('script')

@stop
