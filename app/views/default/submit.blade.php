@section("content")

	<div class="container main">
		<div class="container">
			<h1>{{{ trans("submit.title") }}}</h1>
			<div class="col-md-6">
				<p>
					<strong>{{{ trans("submit.guidelines.upload.title") }}}</strong>
					<ul>
						<li>{{{ trans("submit.guidelines.upload.search") }}}</li>
						<li>{{{ trans("submit.guidelines.upload.quality") }}}</li>
						<li>{{{ trans("submit.guidelines.upload.source") }}}</li>
					</ul>
				</p>
				<p>
					<strong>{{{ trans("submit.guidelines.tagging.title") }}}</strong>
					<ul>
						<li>{{{ trans("submit.guidelines.tagging.required") }}}</li>
						<li>{{{ trans("submit.guidelines.tagging.runes") }}}</li>
						<li>{{{ trans("submit.guidelines.tagging.cv") }}}</li>
					</ul>
				</p>
			</div>
			<div class="col-md-6">
				{{ Form::open(["files" => true, "class" => "form-horizontal"]) }}

					<div class="form-group">
						<input type="file" name="song">
						<p class="help-block">
							{{{ trans("submit.upload.desc") }}}
						</p>
					</div>

					<div class="form-group">
						<input type="text" class="form-control" name="comment" placeholder="{{{ trans("submit.comment.label") }}}">
						<p class="help-block">
							{{{ trans("submit.comment.desc") }}}
						</p>
					</div>

					<div class="form-group" style="display: none" id="daypass">
						<input type="text" class="form-control" name="daypass" placeholder="{{{ trans("submit.daypass.label") }}}">
						<p class="help-block">
							{{{ trans("submit.daypass.desc") }}}
						</p>
					</div>

					<button type="submit" class="btn btn-default ajax-upload">
						{{{ trans("submit.upload.label") }}}
					</button>

				{{ Form::close() }}
			</div>
			<hr>
		</div>

		<hr>
		<div class="container">
			<div class="col-md-6">
				<h2 class="text-success text-center">{{{ trans("submit.accepts") }}}</h2>
				<br>
				@foreach ($accepts as $accept)
					<div class="row">
						<div class="col-md-12">
							@if ($accept["accepted"] == 2)
								<span class="text-success">
									{{{ $accept["meta"] }}}
								</span>
							@else
								{{{ $accept["meta"] }}}
							@endif
							
						</div>
					</div>
					<hr>
				@endforeach
			</div>
			<div class="col-md-6">
				<h2 class="text-danger text-center">{{{ trans("submit.declines") }}}</h2>
				<br>
				@foreach ($declines as $decline)
					<div class="row">
						<div class="col-md-8" style="overflow-x: hidden">{{{ $decline["meta"] }}}</div>
						<div class="col-md-4 text-danger">{{{ $decline["reason"] }}}</div>
					</div>
					<hr>
				@endforeach
			</div>

		</div>
		

	</div>

@stop
