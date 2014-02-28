@section("content")

	<div class="container main">
		<div class="col-md-4">
			<div class="col-xs-6">
				<button class="btn btn-danger" data-toggle="modal" data-target="#help">Help</button>
			</div>
			<div class="col-xs-6">
				<button class="btn btn-info" data-toggle="modal" data-target="#other">What not to accept</button>
			</div>
		</div>
	</div>	
	<hr>
	@foreach ($pending as $p)
		@if ($p["dupe_flag"])
			<div class="well" style="background-color: rgba(217, 83, 79, 0.5); padding-bottom: 0">
		@else
			<div class="well" style="padding-bottom: 0">
		@endif
			{{ Form::open(["url" => "/admin/pending/" . $p["id"], "class" => "form-horizontal"]) }}
				<div class="container" style="width: 100%">
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Artist</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" value="{{{ $p["artist"] }}}" placeholder="Artist" name="artist">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Title</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" value="{{{ $p["track"] }}}" placeholder="Title" name="title">
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Album</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" value="{{{ $p["album"] }}}" placeholder="Album" name="album">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Tags</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" placeholder="Tags" name="tags">
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-4 input-sm">Uploader</label>
							<div class="col-xs-8">
								<p class="form-control-static input-sm">{{{ $p["submitter"] }}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-4 input-sm">
								Bitrate
							</label>
							<div class="col-xs-8">
								<p class="form-control-static input-sm" style="overflow: hidden; white-space: nowrap">{{{ ceil($p["bitrate"] / 1000) }}}kbps {{{ $p["mode"] ?: "" }}}</p>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-4 input-sm">Size</label>
							<div class="col-xs-8">
								<p class="form-control-static input-sm">
									<button class="btn btn-xs btn-primary">
										{{{ ceil($p["length"]) ?: 0 }}}s, {{{ number_format($p["filesize"] / 1000000, 2) }}}MiB
									</button>
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-4 input-sm">Name</label>
							<div class="col-xs-8">
								<p class="form-control-static input-sm" style="overflow: hidden; white-space: nowrap">
									<a href="/admin/pending-song/{{{ $p["id"] }}}">
										{{{ strlen($p["origname"]) > 17 ? preg_replace("/(.{1,14})(.*)(\..*)/", "$1..$3", $p["origname"]) : $p["origname"] }}}
									</a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-4 input-sm">Comment</label>
							<div class="col-xs-8">
								<p class="form-control-static input-sm">{{{ $p["comment"] }}}</p>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-4 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="accept" class="btn btn-sm btn-success accept-song">Accept</button>
							</label>
							<div class="col-xs-8">
								<div class="checkbox">
									<input type="checkbox" name="good" value="1"> Good Upload?
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-4 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="decline" class="btn btn-sm btn-danger decline-song">Decline</button>
							</label>
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm" placeholder="Reason for declining">
							</div>
						</div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	@endforeach



	<div class="modal bs-modal-lg fade" id="help">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Accepting and Declining Pending Songs.</h4>
				</div>
				<div class="modal-body" style="max-height: 500px; overflow-y: scroll">
					<h3 id="colours">Colours</h3>
					<p>
						<span class="text-danger">Red entries</span> are potential duplicates.
						<br>
						<span class="text-success">Green entries</span> are replacement candidates.
					</p>

					<h3 id="searching">Searching</h3>
					<p>
						<form class="form-inline">
							<div class="form-group">
								<input type="text" placeholder="Search" class="form-control">
							</div>
							<div class="form-group"><p class="help-block"> before you accept something blindly.</p></div>
						</form> 
					</p>

					<h3 id="tagging">Tagging</h3>
					<p>
						Tags are a space-delimited list of search terms that are attached to a track and help people find a song.<br>
						You do not need to add any of the words in <b>Artist</b>, <b>Title</b> or <b>Album</b>.
					</p>
					<p><b>SONGS MUST NOT HAVE ALL-JAPANESE METADATA. USE ROMAJI.</b><br>The rest should be self-explanatory.</p>

					<h3 id="accepting">Accepting</h3>
					<p>
						If a song is particularly good, mark it as <b><input type="checkbox"> Good</b><br>
						This can help to identify consistently good uploaders, who will be shown with a <span class="text-success"><b>(number)</b></span> next to their name or IP.<br>
						(Anonymous users are identified by IP, Logged in users by Name).
					</p>
					<p>
						Sometimes a user will give you something ripped from a CD with incomplete metadata, or tags in the file might be missing.
						In this case, the comment or original filename are what you're looking for to identify the file. If in doubt, decline.
					</p>

					<h3 id="replacing">Replacing</h3>
					<p>
						If an entry is <span class="text-success">green</span>, when you accept the song it will be replaced.
					</p>
					<p>
						If you want to force-replace a song, click <button class="btn btn-xs btn-warning">Replace</button> and then enter the ID of the song that should be replaced.
					</p>

					<h3 id="declining">Declining</h3>
					<p>There's an entire modal dedicated to what not to accept.</p>
					<p>You should generally decline shit that is bad; you are a safety net.</p>
					<p>If you decline and leave a reason in there, it will show up on the submit page.</p>



				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal bs-modal-lg fade" id="other">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Shit you shouldn't accept ever.</h4>
				</div>
				<div class="modal-body">
					<h2 class="text-warning">Your ass will be toast if you accept any of the following:</h2>
					<p>
						<ul>
							<li>Mashups</li>
							<li>Bad Quality Songs (&lt;128kbps is already auto-rejected)</li>
							<li>Youtube rips</li>
							<li>Off-vocals</li>
							<li>Single-instrument tracks (e.g. piano versions)</li>
							<li>Songs with heavy bass that aren't perfect quality</li>
							<li>Songs with all-japanese metadata (unless romaji, etc. is given)</li>
						</ul>
					</p>
					<h2 class="text-danger">You have been warned.</h2>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script>
		$("#volume-pending").val(localStorage["volume"]);

		$("#volume-pending").change(function (event) {
			localStorage["volume"] = $(this).val();
			$("#pending-player").jPlayer("volume", Math.pow(($(this).val() / 100), 2.0));
		});

		$("#pending-player").jPlayer({
			ready: function () {
				$(".play-button").click(function (e) {
					e.preventDefault();
					var url = $(this).attr("data-href");
					$("#pending-player").jPlayer("clearMedia");
					$("#pending-player").jPlayer("setMedia", {'mp3': url});
					$("#pending-player").jPlayer("play");
				});
				$("#pause").click(function () {
					$("#pending-player").jPlayer("pause");
				});
			},
			volume: Math.pow(($("#volume-pending").val() / 100), 2.0),
			supplied: "mp3",
			swfPath: swfpath
		});
	</script>
@stop
