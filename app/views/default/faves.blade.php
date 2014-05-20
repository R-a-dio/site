@section("content")

	<div class="container main content">
		<h1 class="text-center">{{{ trans("faves.title") }}}</h1>
		<div class="col-md-8">
			{{ Form::open(['url' => "/faves"]) }}
				<div class="input-group">
					<input type="text" class="form-control" placeholder="{{{ trans("faves.placeholder") }}}" name="nick" id="nickname" value="{{{ $nick ?: "" }}}">
					<div class="input-group-btn">
						<button class="btn btn-info" type="submit">
							{{{ trans("faves.button") }}}
						</button>
					</div>
				</div>
			{{ Form::close() }}

		</div>
		@if ($faves)
		<div class="col-md-4">
			<a href="/faves/{{{ $nick }}}?dl=true" class="btn btn-primary">{{{ trans("faves.download") }}}</a>
		</div>
		<div class="col-md-12">
			<div class="text-center">
				{{ $faves->links() }}
			</div>
			<div class="text-center text-success">
				{{{ trans("faves.count") }}}: {{{ $faves->getTotal() }}}
			</div>
			<div class="row visible-md visible-lg">
					<div class="col-sm-8 text-center" style="margin-bottom: 10px">
						<h4>{{{ trans("faves.metadata") }}}</h4>
					</div>
					<div class="col-sm-4 text-center" style="margin-bottom: 10px">
						<h4>{{{ trans("faves.request") }}}</h4>
					</div>
			</div>
			<hr style="margin-top: 3px; margin-bottom: 8px;">

			@foreach ($faves as $f)

				<div class="row">
					<div class="col-sm-8 text-center" style="margin-bottom: 10px">
						<span class="text-info">{{{ $f["meta"] }}}</span>
					</div>
					<div class="col-sm-4" style="margin-bottom: 10px">
						@if ($f["tracks_id"] && requestable($f["lastrequested"], $f["requestcount"]))
							{{ Form::open(["url" => "/request/{$f["tracks_id"]}"]) }}
								<button type="submit" name="id" value="{{ $f["tracks_id"] }}" class="btn btn-block btn-success request-button">
									{{{ trans("faves.request") }}}
								</button>
							{{ Form::close() }}
						@else
							<button class="btn btn-block btn-danger request-button disabled">
								{{ trans("faves.request") }}
							</button>
						@endif
					</div>
				</div>	
				<hr style="margin-top: 3px; margin-bottom: 8px;">
			@endforeach
			<div class="text-center">
				{{ $faves->links() }}
			</div>
		</div>
		@endif
	</div>

@stop
