@section("content")

	<div class="container main">
		<div class="container">
			<div class="col-md-12">
				<h1>Submit</h1>
				<h4 class="text-muted">R/a/dio Presents: Papa John's&trade; guide to not uploading shit!</h4>
				<p>
					<strong>Step 1:</strong>
					{{ Form::open(["url" => "/search", "class" => "ajax-search form-inline"]) }}
						<div class="form-group">
							<input type="text" name="q" class="form-control" placeholder="Search first bitch">
						</div>
						<button type="submit" class="btn btn-info">Search</button>
					{{ Form::close() }}
				</p>
				<p>
					<strong>Step 2:</strong>
					<br>
					Learn to tag your damn files properly.
					<ul>
						<li>No runes (Romaji if needed)</li>
						<li>Artist and Title minimum</li>
						<li>Only 2 artists in the artist field maximum even if Japan thinks otherwise.</li>
						<li><strong>None of that Character (cv. Artist) shit or heads will roll.</strong></li>
					</ul>
				</p>
			</div>
			<hr>
		</div>

		<div class="row">
			{{ Form::open(["files" => true, "class" => "form-horizontal col-sm-8 col-sm-offset-2"]) }}

				<div class="form-group">
					<label class="form-label col-sm-2">Song</label>
					<div class="col-sm-10">
						<input type="file" name="song">
						<p class="help-block">
							Upload a song to the R/a/dio database. Try to keep MP3s to around 15MB.
						</p>
					</div>
				</div>

				<div class="form-group">
					<label class="form-label col-sm-2">Comment</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="comment" placeholder="Comment">
						<p class="help-block">
							Add the source, artist and title if tags are missing, etc.
						</p>
					</div>
				</div>

				<button type="submit" class="btn btn-default ajax-upload col-sm-offset-2">
					Upload Song
				</button>

			{{ Form::close() }}
		</div>
		<hr>
		<div class="container">
			<div class="col-md-6">
				<h2 class="text-success text-center">Accepts</h2>
				<table class="table table-striped">
					<thead>
						<th>Metadata</th>
					</thead>
					<tbody>
						@foreach ($accepts as $accept)
							@if ($accept["good_upload"])
								<tr class="success">
							@else
								<tr>
							@endif
								<td>{{{ $accept["meta"] }}}</td>
							</tr>
						@endforeach
					</tbody>
					
				</table>
			</div>
			<div class="col-md-6">
				<h2 class="text-danger text-center">Declines</h2>

				<table class="table table-striped table-hover">
					<thead>
						<th>Metadata</th>
						<th>Reason</th>
					</thead>
					<tbody>
						@foreach ($declines as $decline)
							<tr>
								<td>{{{ $decline["meta"] }}}</td>
								<td>{{{ $decline["reason"] }}}</td>
							</tr>
						@endforeach
					</tbody>
					
				</table>
			</div>

		</div>
		

	</div>

@stop
