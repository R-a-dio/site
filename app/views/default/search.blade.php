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
			<div class="row visible-lg">
				<div class="col-md-8">
					<div class="col-sm-6 text-center" style="margin-bottom: 10px">
						<h4>{{{ trans("search.metadata.artist") }}}</h4>
					</div>
					<div class="col-sm-6 text-center" style="margin-bottom: 10px">
						<h4>{{{ trans("search.metadata.track") }}}</h4>
					</div>
				</div>
				<div class="col-md-4">
					<div class="col-sm-4 text-center" style="margin-bottom: 10px">
						<h4>{{{ trans("search.fave") }}}</h4>
					</div>
					<div class="col-sm-8 text-center" style="margin-bottom: 10px">
						<h4>{{{ trans("search.requestable") }}}</h4>
					</div>
				</div>
			</div>
			<hr style="margin-top: 3px; margin-bottom: 8px;">

			@foreach ($search["data"] as $result)

				<div class="row">
					<div class="col-md-8">
						<div class="col-sm-6 text-center" style="margin-bottom: 10px">
							<span class="text-danger">{{{ $result["artist"] }}}</span>
						</div>
						<div class="col-sm-6 text-center" style="margin-bottom: 10px">
							<span class="text-info">{{{ $result["track"] }}}</span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="col-sm-4" style="margin-bottom: 10px">
							<button class="btn btn-block btn-danger fave-button">
								{{{ trans("search.fave") }}} <i class="fa fa-heart"></i>
							</button>
						</div>
						<div class="col-sm-8" style="margin-bottom: 10px">
							@if ($result["cooldown"])
								<button class="btn btn-block btn-danger request-button disabled">
									{{{ trans("search.cooldown") }}}
								</button>
							@else
								<button class="btn btn-block btn-success request-button" href="/request/{{ $result["id"] }}">
									{{{ trans("search.request") }}}
								</button>
							@endif
						</div>
					</div>	
				</div>	
				<hr style="margin-top: 3px; margin-bottom: 8px;">
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
