@section("content")

	<div class="container main">
		<h1>Notifications</h1>
		
		@foreach ($notifications as $notification)
			<div class="row">
				<hr>
				{{ Markdown::render($notification->notification) }}
			</div>
		@endforeach

		<div class="text-center">
			{{ $notifications->links() }}
		</div>
	</div>

@stop
