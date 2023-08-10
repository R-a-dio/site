@section("content")

@if (!Auth::user()->canViewPending())
	<h2>You shouldn't be here.</h2>
@else
	<div class="container main">
		<div class="col-lg-4">
			<div class="row">
				<div class="col-xs-6 col-xs-offset-3">
					<button class="btn btn-block btn-danger" data-toggle="modal" data-target="#help">Help</button>
					<button class="btn btn-block btn-info" data-toggle="modal" data-target="#other">Accepting guidelines</button>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="well text-center text-primary">
				There are currently {{{ count($pending) }}} pending tracks awaiting approval.
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
			<div class="well pending-song" style="background-color: rgba(217, 83, 79, 0.5); padding-bottom: 0">
		@elseif ($p["replacement"])
			<div class="well pending-song" style="background-color: rgba(137, 232, 148, 0.5); padding-bottom: 0">
		@else
			<div class="well pending-song" style="padding-bottom: 0">
		@endif
			{{ Form::open(["url" => "/admin/pending/" . $p["id"], "class" => "form-horizontal"]) }}
				<div class="container" style="width: 100%">
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Artist</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm artist-field" value="{{{ $p->artist }}}" placeholder="Artist" name="artist" {{ $p["replacement"] ? "disabled" : "" }}>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Title</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm title-field" value="{{{ $p->track }}}" placeholder="Title" name="title" {{ $p["replacement"] ? "disabled" : "" }}>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Album</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm album-field" value="{{{ $p->album }}}" placeholder="Album" name="album" {{ $p["replacement"] ? "disabled" : "" }}>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 input-sm">Tags</label>
							<div class="col-xs-10">
								<input type="text" class="form-control input-sm" placeholder="Tags" name="tags" {{ $p["replacement"] ? "disabled" : "" }}>
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							<!-- <label class="control-label col-xs-4 input-sm">Uploader</label> -->
							<div class="col-xs-16">
								<p style="overflow:hidden" class="form-control-static input-sm ip-field">{{{ $p->submitter }}}</p>
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
								<p class="form-control-static input-sm comment-field"><small>{{{ $p->comment }}}</small></p>
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
									<a href="/admin/pending-song/{{{ $p["id"] }}}" title="{{{ $p->file_name }}}" class="btn btn-warning btn-xs">
										{{{ strlen($p->file_name) > 17 ? preg_replace("/(.{1,10})(.*)(\.(mp3|flac))/u", "$1..$3", $p->file_name) : $p->file_name }}}
									</a>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						@if (Auth::user()->canEditPending())
						<div class="form-group">
							<div class="col-xs-1"></div>
							<label class="control-label col-xs-3 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="replace" class="btn btn-sm btn-warning accept-song">Replace</button>
							</label>
							<label class="control-label col-xs-3 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="accept" class="btn btn-sm btn-success accept-song" {{ $p["replacement"] ? "disabled" : "" }}>Accept</button>
							</label>
							<div class="col-xs-3">
								<div class="checkbox">
									<input type="checkbox" name="good" value="1"> Good?
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-3 col-xs-offset-1" >
								<input type="text" name="replace" value="{{ $p["replacement"] ?: "" }}" class="form-control input-sm" placeholder="Rep. ID" {{ $p["replacement"] ? "disabled" : "" }}>
								@if ($p["replacement"])
								<input type="hidden" name="replace" value="{{ $p["replacement"] }}">
								@endif
							</div>
							<label class="control-label col-xs-3 input-sm" style="padding-top: 0">
								<button type="submit" name="choice" value="decline" class="btn btn-sm btn-danger decline-song">Decline</button>
							</label>
							<div class="col-xs-3">
								<input type="text" name="reason" class="form-control input-sm" placeholder="Reason">
							</div>
						</div>
						@endif
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
					<h4 class="modal-title">Accepting guidelines</h4>
				</div>
				<div class="modal-body">
					<h2 class="text-warning">Keep these in mind when accepting songs:</h2>
					<p>
						<ul>
							<li>Accept full size releases only (meaning no TV size anime openings, endings, etc).</li>
							<li>We follow Japanese name order for artist (for example, Kugimiya Rie instead of Rie Kugimiya). If you're not sure, google the artist name, then put it the other way around (protips below).</li>
							<li>Sites that use western name order: Wikipedia (usually), Anime News Network</li>
							<li>Sites that use Japanese name order: AniDB, MyAnimeList (on the site; western order on google search results)</li>
							<li>If the song is by an idol group, use the idol group name as the artist name and add the singers in tags. Character names can also be added to tags, but are not necessary.</li>
							<li>Always use the artist(s) as the artist name, not the character. (good: Hirano Aya - Hare Hare Yukai; bad: Suzumiya Haruhi - Hare Hare Yukai)</li>
							<li>Add as much information as (reasonably) possible in the tags. Too much is better than too little, for example if a show is often referred to with an English title (or has an official one), add that as well.</li>
							<li>Use "artist feat. someone - song" instead of "artist - song feat. someone", even if it was released as the latter.</li>
							<li>を-> "wo", not "o". へ -> "he", not "e". は-> "wa", not "ha".</li>
							<li>Particles are always lower case; other words are Upper Case.</li>
							<li>Follow official artist stylization of artist name (for example "AZKi" instead of "Azki").</li>
							<li>For romanization, if you're unsure, check the database for what's most commonly used and go with that. If there's nothing from the artist in the database, use what AniDB uses. If they're not on AniDB, use what you think AniDB would use.</li>
						</ul>
					</p>

					<h2 class="text-warning">Don't accept:</h2>
					<p>
						<ul>
							<li>Don't accept anything below 192kbps.</li>
							<li>Don't accept youtube rips. If you don't know if something is a youtube rip or not, don't do anything.</li>
							<li>It's not exactly required if you trust your ears, but consider <a href="https://interviewfor.red/en/spectrals.html">reading this</a>.</li>
							<li>Read the stuff on <a href="https://r-a-d.io/submit">submit page</a> for more information on what should be declined.</li>
						</ul>
					</p>
					<h2 class="text-warning">Words of warning:</h2>
					<p>
						<ul>
							<li>Don't modify artist or song name on old songs. This will reset favorites on the song. If you think they should be changed anyway, ask Vin/Kethsar/exci. Album and tags can be edited without resetting anything.</li>
							<li>You can do ".i id" on irc to check if the song only has a few favourites and/or plays to figure out if it's old. Or just look at the ID and extrapolate. You probably don't want to change anything anyway, just ask someone else.</li>
						</ul>
					</p>
                                        <h2 class="text-warning">Useful sites:</h2>
                                        <p>
                                                <ul>
							<li><a href="https://anidb.net/creator">AniDB (anime)</a></li>
							<li><a href="https://vgmdb.net/search">VGMDB (all kinds of Japanese releases)</a></li>
							<li><a href="https://vndb.org/s">VNDB (visual novels)</a></li>
							<li><a href="https://myanimelist.net/?type=person&keyword=">MyAnimeList (anime)</a></li>
                                                </ul>
                                        </p>
                                        <h2 class="text-warning">On vtumors:</h2>
                                        <p>
                                                <ul>
                                                        <li>Accept vtumors when song production was by a Japanese artist (for example, all of hololive JP). This generally also means you can accept any vtumor, even if not Japanese, if they're managed by a Japanese vtumor factory. If you're unsure, don't do anything.</li>
                                                        <li>In general, same rules apply as to other submissions; an anime avatar alone doesn't make it /a/ or /jp/. You can still accept English vtumor (even outside Hololive or Nijisanji, etc) songs if the song production is Japanese. If you're unsure, don't do anything.</li>
							<li>Special case: if a vtumor song is in a language that isn't English or Japanese, don't accept.</li>
                                                </ul>
                                        </p>



				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<!-- exci was here -->
<script>
if (localStorage.getItem("filtered_ip") === null) {
    localStorage.setItem("filtered_ip", "");
}

if (localStorage.getItem("filtered_title") === null) {
    localStorage.setItem("filtered_title", "");
}

if (localStorage.getItem("filtered_artist") === null) {
    localStorage.setItem("filtered_artist", "");
}

if (localStorage.getItem("filtered_comment") === null) {
    localStorage.setItem("filtered_comment", "");
}

// more setup
var pending_songs_ips = document.getElementsByClassName("ip-field");
var pending_songs_artists = document.getElementsByClassName("artist-field");
var pending_songs_titles = document.getElementsByClassName("title-field");
var pending_songs_comments = document.getElementsByClassName("comment-field");

// add ip input field container
var container = document.createElement("div");
container.id = "ip-input-container";
container.style.cssText = "display: flex; align-items: center; justify-content: center; padding-bottom: 20px;";

// add ip input field
var ip_input_field = document.createElement("input");
ip_input_field.id = "ip-input";
ip_input_field.style.cssText = "width: 300px; margin-left: 10px; margin-right: 10px; text-align: center;";
ip_input_field.placeholder = "enter ip to filter";

if (localStorage.getItem("filtered_ip") != "") {
  ip_input_field.value = localStorage.getItem("filtered_ip");
}

document.getElementsByTagName("hr")[0].after(container);
container.append(ip_input_field);

// add artist input field
var artist_input_field = document.createElement("input");
artist_input_field.id = "artist-input";
artist_input_field.style.cssText = "width: 300px; margin-left: 10px; margin-right: 10px; text-align: center;";
artist_input_field.placeholder = "enter artist to filter";

if (localStorage.getItem("filtered_artist") != "") {
  artist_input_field.value = localStorage.getItem("filtered_artist");
}

document.getElementsByTagName("hr")[0].after(container);
container.append(artist_input_field);

// add title input field
var title_input_field = document.createElement("input");
title_input_field.id = "title-input";
title_input_field.style.cssText = "width: 300px; margin-left: 10px; margin-right: 10px; text-align: center;";
title_input_field.placeholder = "enter title to filter";

if (localStorage.getItem("filtered_title") != "") {
  title_input_field.value = localStorage.getItem("filtered_title");
}

document.getElementsByTagName("hr")[0].after(container);
container.append(title_input_field);

// add comment input field
var comment_input_field = document.createElement("input");
comment_input_field.id = "comment-input";
comment_input_field.style.cssText = "width: 300px; margin-left: 10px; margin-right: 10px; text-align: center;";
comment_input_field.placeholder = "enter comment to filter";

if (localStorage.getItem("filtered_comment") != "") {
  comment_input_field.value = localStorage.getItem("filtered_comment");
}

document.getElementsByTagName("hr")[0].after(container);
container.append(comment_input_field);

// trigger the important stuff every time something changes in ip input field
ip_input_field.addEventListener('input', (event) => {
  filter_ip();
});

artist_input_field.addEventListener('input', (event) => {
  filter_artist();
});

title_input_field.addEventListener('input', (event) => {
  filter_title();
});

comment_input_field.addEventListener('input', (event) => {
  filter_comment();
});

function filter_ip() {
  localStorage.setItem("filtered_ip", document.querySelector("#ip-input").value);
  
  Array.from(pending_songs_ips).forEach(function (ip) {
    // initially hide all songs
    ip.closest(".pending-song").style.display = "none";

    // only display songs that match ip
    if (ip.textContent.toLowerCase().includes(localStorage.getItem("filtered_ip").toLowerCase())) {
      ip.closest(".pending-song").style.display = "block";
    }

    // if ip input field is empty, show everything
    if (ip_input_field.value == "") {
      ip.closest(".pending-song").style.display = "block";
    }
  });
}

function filter_artist() {
  localStorage.setItem("filtered_artist", document.querySelector("#artist-input").value);
  
  Array.from(pending_songs_artists).forEach(function (artist) {
    // initially hide all songs
    artist.closest(".pending-song").style.display = "none";

    // only display songs that match artist
    if (artist.value.toLowerCase().includes(localStorage.getItem("filtered_artist").toLowerCase())) {
      artist.closest(".pending-song").style.display = "block";
    }

    // if artist input field is empty, show everything
    if (artist_input_field.value == "") {
      artist.closest(".pending-song").style.display = "block";
    }
  });
}

function filter_title() {
  localStorage.setItem("filtered_title", document.querySelector("#title-input").value);
  
  Array.from(pending_songs_titles).forEach(function (title) {
    // initially hide all songs
    title.closest(".pending-song").style.display = "none";

    // only display songs that match title
    if (title.value.toLowerCase().includes(localStorage.getItem("filtered_title").toLowerCase())) {
      title.closest(".pending-song").style.display = "block";
    }

    // if title input field is empty, show everything
    if (title_input_field.value == "") {
      title.closest(".pending-song").style.display = "block";
    }
  });
}

function filter_comment() {
  localStorage.setItem("filtered_comment", document.querySelector("#comment-input").value);
  
  Array.from(pending_songs_comments).forEach(function (comment) {
    // initially hide all songs
    comment.closest(".pending-song").style.display = "none";

    // only display songs that match comment
    if (comment.textContent.toLowerCase().includes(localStorage.getItem("filtered_comment").toLowerCase())) {
      comment.closest(".pending-song").style.display = "block";
    }

    // if comment input field is empty, show everything
    if (comment_input_field.value == "") {
      comment.closest(".pending-song").style.display = "block";
    }
  });
}

if (!localStorage.getItem("filtered_ip") == "") {
  filter_ip();
} else if (!localStorage.getItem("filtered_artist") == "") {
  filter_artist();
} else if (!localStorage.getItem("filtered_title") == "") {
  filter_title();
} else if (!localStorage.getItem("filtered_comment") == "") {
  filter_comment();
}
</script>
@endif
@stop
