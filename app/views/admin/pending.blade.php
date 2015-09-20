@section("content")

	<div class="container main">
		<div class="col-lg-4">
			<div class="row">
				<div class="col-xs-6 col-xs-offset-3">
					<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#help">Help</button>
					<button class="btn btn-block btn-info" data-toggle="modal" data-target="#other">What not to accept</button>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="well text-center text-primary">
				Announcements will go here
			</div>
		</div>
	</div>

	<div style="position: fixed; bottom: 0; z-index: 9999; background: rgba(0, 0, 0, 0.3); padding: 20px 30px 0 30px; width: 100%">

		<div class="container">
			<div id="player-test">
				<div>
					<div class="col-xs-1" style="padding-right: 0" id="play-pause">
						<i class="fa fa-play audio-icon" id="audio-play"></i>
						<i class="fa fa-pause audio-icon" id="audio-pause" style="display: none"></i>
					</div>
					<div class="col-xs-5" id="audio-slider">
						<input id="audio-progress" type="range" class="track-slider" min="0" max="1000" step="1" value="0">
						<div class="buffer" style="margin-right: 30px">
							<div id="audio-buffer" class="buffer-bar" style="width: 0%"></div>
						</div>
					</div>
					<div class="col-xs-1" id="audio-time">
						0:00
					</div>
					<div class="col-xs-1" style="padding-right: 0">
						<i class="fa fa-volume-up audio-icon" id="volume-high"></i>
						<i class="fa fa-volume-down audio-icon" id="volume-low" style="display: none"></i>
						<i class="fa fa-volume-off audio-icon" id="volume-muted" style="color: rgb(153, 153, 153); display: none"></i>
					</div>
					<div class="col-xs-2" style="padding-right: 0">
						<input type="range" class="track-slider" min="0" max="100" step="1" value="80" id="volume">
						<div class="buffer" style="margin-right: 15px">
							<div id="audio-bar" class="buffer-bar" style="width: 80%"></div>
						</div>
						
					</div>
					<div class="col-xs-2">
						<button class="btn btn-xs btn-danger" style="margin-top: 2px;" id="audio-reset">debug</button>
					</div>
				</div>
			</div>
			<p id="np" class="text-center" style="color: #fff"></p>
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
								<input type="text" class="form-control input-sm" value="{{{ $p->artist }}}" placeholder="Artist" name="artist">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Title</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" value="{{{ $p->track }}}" placeholder="Title" name="title">
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Album</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" value="{{{ $p->album }}}" placeholder="Album" name="album">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Tags</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" placeholder="Tags" name="tags">
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							<!-- <label class="control-label col-xs-4 input-sm">Uploader</label> -->
							<div class="col-xs-16">
								<p style="overflow:hidden" class="form-control-static input-sm">{{{ $p->submitter }}}</p>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-xs-4 input-sm">
								Bitrate
							</label> -->
							<div class="col-xs-16">
								<p
									class="form-control-static input-sm"
									style="white-space: nowrap">{{{ ceil($p->bitrate / 1000) }}}kbps {{{ $p->mode ?: "" }}}</p>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<!-- <label class="control-label col-xs-4 input-sm">Comment</label> -->
							<div class="col-xs-16">
								<p class="form-control-static input-sm"><small>{{{ $p->comment }}}</small></p>
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							<!-- <label class="control-label col-xs-4 input-sm">Size</label> -->
							<div class="col-xs-16">
								<p class="form-control-static input-sm">
									<button
										type="button"
										class="btn btn-xs btn-primary play-button"
										data-url="/admin/pending-song/{{{ $p->id }}}"
										data-format="{{ $p->format ?: 'mp3' }}">
										{{{ date("i\ms\s", floor($p->length) ?: 0) }}}, {{{ number_format($p->file_size / 1048576, 2) }}}MB
									</button>
								
								</p>
							</div>
						</div>
						<div class="form-group">
							<!-- <label class="control-label col-xs-4 input-sm">Name</label> -->
							<div class="col-xs-16">
								<p class="form-control-static input-sm" style="white-space: nowrap">
									<a href="/admin/pending-song/{{{ $p["id"] }}}" title="{{{ $p->file_name }}}" target="_blank" class="btn btn-warning btn-xs">
										{{{ strlen($p->file_name) > 17 ? preg_replace("/(.{1,10})(.*)(\.(mp3|flac))/u", "$1..$3", $p->file_name) : $p->file_name }}}
									</a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<div class="col-xs-1"></div>
							<label class="control-label col-xs-3 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="replace" class="btn btn-sm btn-warning accept-song">Replace</button>
							</label>
							<label class="control-label col-xs-3 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="accept" class="btn btn-sm btn-success accept-song">Accept</button>
							</label>
							<div class="col-xs-3">
								<div class="checkbox">
									<input type="checkbox" name="good" value="1"> Good?
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-1"></div>
							<div class="col-xs-3" >
								<input type="text" name="replace" value="" class="form-control input-sm" placeholder="Rep. ID">
							</div>
							<label class="control-label col-xs-3 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="decline" class="btn btn-sm btn-danger decline-song">Decline</button>
							</label>
							<div class="col-xs-3">
								<input type="text" name="reason" class="form-control input-sm" placeholder="Reason">
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
@stop
