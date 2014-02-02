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

			@foreach ($search["data"] as $result)

				<div class="row">
					<div class="col-md-8">
						<span class="text-danger">{{{ $result["artist"] }}}</span> - <span class="text-info">{{{ $result["track"] }}}</span>
					</div>
					<div class="col-md-4">
						<div class="col-sm-4">
							<button class="btn btn-block btn-danger">
								{{{ trans("search.fave") }}} <i class="fa fa-heart"></i>
							</button>
						</div>
						<div class="col-sm-8">
							@if ($result["cooldown"])
								<button class="btn btn-block btn-danger request-button disabled">
									{{{ trans("search.cooldown") }}}
								</a>
							@else
								<button class="btn btn-block btn-success request-button" href="/request/{{ $result["id"] }}">
									{{{ trans("search.request") }}}
								</a>
							@endif
						</div>
					</div>	
				</div>	

			@endforeach

			<div class="text-center">
				{{ $links }}
			</div>
			

		</div>
	@endif


</div>

@stop

@section('script')

@stop
