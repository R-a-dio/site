@section("content")

	<div class="container main">
		<div class="row">
			<div class="row">
				<div class="col-lg-8">
					{{ Form::open(["url" => "/admin/songs/search"]) }}
						<div class="input-group">
							<input type="text" class="form-control" placeholder="{{{ trans("search.placeholder") }}}" name="q" id="search" value="{{{ $search }}}">
							<div class="input-group-btn">
								<button class="btn btn-info" type="submit">
									{{{ trans("search.button") }}}
								</button>
							</div>
						</div>
					{{ Form::close() }}
				</div>
				<div class="col-lg-4">
					<div class="row">
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
									<button class="btn btn-xs btn-default" style="margin-top: 2px;" id="audio-reset">reset state</button>
								</div>
							</div>
						</div>
						<p id="np" class="text-center"></p>
					</div>
				</div>
			</div>

			<hr>
		</div>
	</div>

	@foreach ($results as $result)
		<div class="well" style="padding-bottom: 0; padding-top: 8px">
			{{ Form::open(["url" => "/admin/songs/" . $result["id"], "class" => "form-horizontal"]) }}
				<div class="container" style="width: 100%; padding: 0">
					<div class="col-lg-3">
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">Artist</label>
							<div class="col-xs-9">
								<input type="text" class="form-control input-sm" value="{{{ $result["artist"] }}}" placeholder="Artist" name="artist">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">Title</label>
							<div class="col-xs-9">
								<input type="text" class="form-control input-sm" value="{{{ $result["track"] }}}" placeholder="Title" name="title">
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">Album</label>
							<div class="col-xs-9">
								<input type="text" class="form-control input-sm" value="{{{ $result["album"] }}}" placeholder="Album" name="album">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">Tags</label>
							<div class="col-xs-9">
								<input type="text" class="form-control input-sm" placeholder="Tags" name="tags" value="{{{  $result["tags"] }}}">
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">Acceptor</label>
							<div class="col-xs-9">
								<p class="form-control-static input-sm">
									{{{ $result["accepter"] ?: "unknown" }}}
									<span class="text-danger">
										{{{ $result["lasteditor"] ? "(" . $result["lasteditor"] . ")" : "" }}}
									</span>
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">ID</label>
							<div class="col-xs-9">
								<p class="form-control-static input-sm text-danger">
									<b>{{{ $result["id"] }}}</b> 
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">
								LP/LR
							</label>
							<div class="col-xs-9">
								<p class="form-control-static input-sm" style="overflow: hidden; white-space: nowrap">
									{{ $result["lastplayed"] != "0000-00-00 00:00:00" ? time_ago($result["lastplayed"]) : "never" }}
									/
									{{ $result["lastrequested"] != "0000-00-00 00:00:00" ? time_ago($result["lastrequested"]) : "never" }}
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-3 input-sm">
								Priority
							</label>
							<div class="col-xs-6">
								<p class="form-control-static input-sm" style="overflow: hidden; white-space: nowrap">
									{{{ $result["priority"] }}} <span class="text-success">({{{ $result["requestcount"] }}})</span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<div class="col-lg-6">
									<button type="submit" name="action" value="save" class="btn btn-sm btn-block btn-default">
										Save
									</button>
									<button type="button" class="btn btn-sm btn-block btn-primary play-button" data-url="/admin/song/{{{ $result["id"] }}}">
										Play
									</button>
								</div>
								<div class="col-lg-6">
									<a class="btn btn-warning btn-sm btn-block" href="/admin/song/{{{ $result["id"] }}}">
										DL
									</a>
									@if (Auth::user()->isAdmin())
										<button type="submit" name="action" value="delete" class="btn btn-sm btn-block btn-danger">
											Delete
										</button>
									@else
										<button class="btn btn-sm btn-block btn-danger" disabled>
											Delete
										</button>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="form-group">
							<button type="submit" name="action" value="replace" class="btn btn-info btn-block btn-sm btn-default">
								Replace
							</button>
							<input style="margin-top: 5px" type="file" class="form-control input-sm" name="replace-id" placeholder="Replace ID" disabled>
							</div>
						</div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	@endforeach

	<div class="text-center">
		{{ $results->links() }}
	</div>

@stop
