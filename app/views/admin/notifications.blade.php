@section("content")

	<div class="container main">
		<h1 class="text-center text-primary">Events</h1>
		
		<div class="col-md-8 col-md-offset-2">
			<ul class="list-group">
				@foreach ($notifications as $notification)
					@if ($notification->privileges == User::ADMIN)
						<li class="list-group-item list-group-item-info">
					@elseif ($notification->privileges == User::DEV)
						<li class="list-group-item list-group-item-danger">
					@else
						<li class="list-group-item">
					@endif
						<p class="text-center">
							{{{ $notification->notification }}} {{ time_ago($notification->created_at) }}
						</p>
					</li>
				@endforeach
			</ul>
			<div class="text-center">
				{{ $notifications->links() }}
			</div>
		</div>
	</div>

@stop
