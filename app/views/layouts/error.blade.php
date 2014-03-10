@section("content")

	<div class="container main">
		<h1 class="text-center text-primary">Whoops! Something broke.</h1>
		<h2 class="text-center text-danger">{{{ $error }}}</h2>
		@if (isset($reference))
			<h3 class="text-center text-success">{{ var_dump($reference) }}</h3>
		@endif
	</div>

@stop
