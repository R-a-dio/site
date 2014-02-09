@section("content")

	<div class="container main">
		
		{{ Form::open(["files" => true, "class" => "col-sm-6 col-sm-offset-3"]) }}

			<div class="form-group">
				<label>Song</label>
				<input type="file" class="form-control" name="song">
				<p class="help-block">
					Upload a song to the R/a/dio database. Try to keep MP3s to around 15MB.
				</p>
			</div>

			<div class="form-group">
				<label>Comment</label>
				<input type="text" class="form-control" name="comment" placeholder="Comment">
				<p class="help-block">
					
				</p>
			</div>

			<button type="submit" class="btn btn-success ajax-upload">
				Upload Song
			</button>

		{{ Form::close() }}

	</div>

@stop
