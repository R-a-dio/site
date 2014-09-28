@section("content")
	<div class="container main content">
	
	<div class="staffpage-title col-md-12"><h3>Staff</h3></div>
	<div class="panel-default djpage-panel col-md-12 col-sm-12 col-xs-12">
	@foreach($staff as $i => $s)
		@if ($s["role"] == '')
			<div class="col-md-3 col-sm-4 col-xs-6">
				<div class="thumbnail">
					<br>
					<img src="/api/dj-image/{{ $s["id"] }}" alt="{{{ $s["djname"] }}}" height="150" width="150" style="max-height: 150px">
					<div class="text-center staff-name">
						<h4>{{{ $s["djname"] }}}</h4>
					</div>
				</div>
			</div>
		@endif
	@endforeach
	</div>
	
	<div class="staffpage-title col-md-12"><h3>Developers</h3></div>
	<div class="panel-default djpage-panel col-md-12 col-sm-12 col-xs-12">
	@foreach($staff as $i => $s)
		@if ($s["role"] == "dev")
			<div class="col-md-3 col-sm-4 col-xs-6">
				<div class="thumbnail">
					<br>
					<img src="/api/dj-image/{{ $s["id"] }}" alt="{{{ $s["djname"] }}}" height="150" width="150" style="max-height: 150px">
					<div class="text-center staff-name">
						<h4>{{{ $s["djname"] }}}</h4>
					</div>
				</div>
			</div>
		@endif
	@endforeach
	</div>
	
	<div class="staffpage-title col-md-12"><h3>DJs</h3></div>
	<div class="panel-default djpage-panel col-md-12 col-sm-12 col-xs-12">
	@foreach($staff as $i => $s)
		@if ($s["role"] == "dj")
			<div class="col-md-3 col-sm-4 col-xs-6">
				<div class="thumbnail">
					<br>
					<img src="/api/dj-image/{{ $s["id"] }}" alt="{{{ $s["djname"] }}}" height="150" width="150" style="max-height: 150px">
					<div class="text-center staff-name">
						<h4>{{{ $s["djname"] }}}</h4>
					</div>
				</div>
			</div>
		@endif
	@endforeach
	</div>
	
<!--
	@foreach($staff as $i => $s)

		<div class="col-md-3">

			<div class="thumbnail" style="height: 221px">
				<img src="/api/dj-image/{{ $s["id"] }}" alt="{{{ $s["djname"] }}}" height="150" width="150" style="max-height: 150px">
				<div class="text-center staff-name">
					{{{ $s["djname"] }}}
				</div>

				@if ($s["role"] == "dev")
					<p class="text-center text-info">
						Developer
					</p>
				@elseif ($s["role"] == "dj")
					<p class="text-center text-danger">
						DJ
					</p>
				@else
					<p class="text-center text-success">
						Staff
					</p>
				@endif

			</div>
		</div>

	@endforeach
-->
	</div>
@stop
