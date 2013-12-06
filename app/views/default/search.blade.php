@section('content')

<div class="container main">
	<!-- Search Bar -->
	<div class="container">
		<div class="col-md-7 centered">
			<h1 class="text-center text-info"> {{{ trans("search.help.main") }}} </h1>
			{{ Form::open(['url' => $base . "/search" ]) }}
			<div class="input-group">
				<input type="text" class="form-control" placeholder="{{{ trans("search.placeholder") }}}" name="q" id="search" value="{{{ Input::get("q", "") }}}">
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

	<!-- Search Results -->
	<div class="container">

		@foreach ($search as $result)

			@if ($result["break"] == 0)
			<div class="row">
			@endif

				<div class="col-md-4 result-container">

					@if ($result["cooldown"])
					<div class="well search-result cooldown" data-id="{{ $result["id"] }}">
					@else
					<div class="well search-result" data-id="{{ $result["id"] }}">
					@endif
						<h4 class="text-muted"><span class="text-danger">{{{ $result["track"] }}}</span> - <span class="text-info">{{{ $result["artist"] }}}</span></h4>
						<p class="text-muted">
							<span class="text-warning">{{{ trans("search.plays") }}}: ??</span> 
							<span> | </span> 
							<span class="text-info">{{{ trans("search.faves") }}}: ??</span> 
							<span> | </span>
							@if ($result["cooldown"])
								<span class="text-danger">{{{ trans("search.cooldown") }}}</span>
							@else
								<a href="{{ $base }}/request/{{ $result["id"] }}"><span class="text-success">{{{ trans("search.requestable") }}}</span></a>
							@endif
						</p>
					</div>

				</div>

			@if ($result["break"] == 2)
			</div>
			@endif

		@endforeach
		

		

	</div>



</div>

@stop

@section('script')
	<script>
		$('.search-result').popover({
			title: '{{{ trans("search.plays") }}}',
			content: '<p class="text-danger"><a href="{{ $base }}/request">{{{ trans("search.request") }}}</a> <span class="text-muted"> | </span>  {{{ trans("search.popover.lp", ["timeago" => "3 days ago"]) }}}</p> <p class="text-danger">{{ trans("search.popover.login", ["login" => "<a href=\"#\">Log In</a>"]) }}</p>',
			placement: 'top',
			delay: { show: 50, hide: 20 },
			html: true,
			trigger: 'click'
		});
	</script>
@stop
