@section("content")

	<div class="container main">
		<h1>Environment</h1>
		<p>{{{ $environment }}}</p>
		<hr>
		<h1>Failed Logins</h1>
		<hr>
		<table class="table">
			<thead>
				<th>IP</th>
				<th>Username</th>
				<th>Password sha256</th>
				<th>Time</th>
				<th>Remove</th>
			</thead>
			<tbody>
				@foreach ($failed_logins as $fail)
					<tr>
						<td>{{{ $fail["ip"] }}}</td>
						<td>{{{ $fail["user"] }}}</td>
						<td>{{{ $fail["password"] }}}</td>
						<td>{!! time_ago($fail["created_at"]) !!}</td>
						<td>
							{!! Form::open(["method" => "delete"]) !!}
								<button class="btn btn-danger">Remove</button>
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
	</div>

@stop
