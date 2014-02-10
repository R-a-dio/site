@section("content")

	<div class="container main">
		<div class="container">
			<div class="col-md-12">
				<h1>Submit</h1>
				<h4 class="text-muted">R/a/dio Presents: Papa John's&trade; guide to not uploading shit!</h4>
				<p>
					<strong>Step 1:</strong>
					{{ Form::open(["url" => "/search", "class" => "ajax-search"]) }}
						<input type="text" name="q" class="form-control" placeholder="Search first or we're going to teabag you into next week">
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
						<li>None of that Artist1 (cv. Character1) &amp; Artist2 (cv. Character2) &amp; Artist3 (cv. Character3) shite.</li>
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

				<button type="submit" class="btn btn-success ajax-upload col-sm-offset-2">
					Upload Song
				</button>

			{{ Form::close() }}
		</div>
		<hr>
		<div class="container">
			<div class="col-md-6">
				<h2 class="text-success text-center">Accepts</h2>
				<div class="well">
					
				</div>
			</div>
			<div class="col-md-6">
				<h2 class="text-danger text-center">Declines</h2>
				<div class="well">
					
				</div>
			</div>
		</div>
		

	</div>

@stop
