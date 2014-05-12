@section('content')

	<!-- Main Container
	================ -->
	<div class="container main">

		<!-- Content (Dynamic)
		=================== -->
		<div class="container content">

			<div class="row">

				<!-- Logo 1 (Icon)
					============== -->
				<div class="col-md-3 visible-lg visible-md">
					<div class="col-xs-12">
						<img src="/assets/logo_image_small.png" class="hidden-sm" alt="R/a/dio">
					</div>
				</div>


				<div class="col-md-6">

					<div class="row" id="stream-info">

						<!-- Logo 2 (Branded)
							================= -->
						<div class="col-md-6">
							<img id="volume-image" src="/assets/logotitle_2.png" alt="R/a/dio" style="width: 100% !important; margin-bottom: 15px;">
							<div class="well well-sm text-center" style="display: none; margin-bottom: 0;" id="volume-control">
								<p style="margin-bottom: 10px;">Volume Control</p>
								<input id="volume" type="range" min="0" max="100" step="1" value="80">
							</div>
						</div>

						<!-- Player Options
							================ -->
						<div class="col-md-6">
							<button class="btn btn-primary btn-block disabled" id="stream-play" data-loading-text="{{{ trans("stream.loading") }}}"><i class="fa fa-spinner fa-spin"></i></button>
							<button class="btn btn-primary btn-block" id="stream-stop" data-loading-text="{{{ trans("stream.loading") }}}" style="display: none; margin-top: 0;">{{{ trans("stream.stop") }}}</button>
							<div class="btn-group btn-block" style="width:100%">
								<button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">
									{{{ trans("stream.options") }}} <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" style="width: 100%">
									<li><a href="https://stream.r-a-d.io/main.mp3">{{{ trans("stream.links.direct") }}}</a></li>
									<li><a href="/assets/main.mp3.m3u">{{{ trans("stream.links.m3u") }}}</a></li>
									<li><a href="/assets/main.pls">{{{ trans("stream.links.pls") }}}</a></li>
									<li class="divider"></li>
									<li><a href="#help" data-toggle="modal" data-target="#help">{{{ trans("stream.links.help") }}}</a></li>
								</ul>
							</div>
						</div>
						<div class="modal fade bs-modal-lg" id="help">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">R/a/dio Help</h4>
									</div>
									<div class="modal-body">
										<h3>Playing the Stream</h3>
										<p>Simply click the <button class="btn btn-primary btn-sm">Play Stream</button> button in your browser.</p>
										<p>A volume slider will appear, and the slider will change the volume. This is remembered between page loads.</p>
										<p>To play the stream in your browser, you can use any of the following links:</p>
										<ul>
											<li><a href="https://stream.r-a-d.io/main">{{{ trans("stream.links.direct") }}}</a></li>
											<li><a href="/assets/main.mp3.m3u">{{{ trans("stream.links.m3u") }}}</a></li>
											<li><a href="/assets/main.pls">{{{ trans("stream.links.pls") }}}</a></li>
										</ul>

										<h3>Requesting Songs</h3>
										<p>Search for a song first, by entering something into the searchbox at the top (or clicking "Search" in the navbar).</p>
										<p>Then, click on <button class="btn btn-success btn-sm">Request</button></p>
										<p>You can only request every 2 hours.</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->

					</div><!-- /.row#stream-info -->

					<!-- Progress Bar
						================= -->
					<div class="row">

						<div class="col-xs-12">
							<h2 class="text-center" id="current-song">
								<span id="np">
									{{{ $status["np"] }}}
								</span>
							</h2>
						</div>

						<div class="col-xs-12">
							<div class="progress" id="progress">
								<div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%"></div>
							</div>
						</div>

						<div class="col-md-6">
							<p class="text-muted text-center">
								{{{ trans("stream.listeners") }}}: <span id="listeners">{{{ $status["listeners"] }}}</span>
							</p>
						</div>
						<div class="col-md-6">
							<p class="text-muted text-center">
								<span id="progress-current">00:00</span>
								/
								<span id="progress-length">00:00</span>
							</p>
						</div>


					</div><!-- /.row#progress -->

				</div>

				<!-- DJ Image + Name
					================= -->
				<div class="col-md-3">
					<div class="col-xs-12">
						<div class="thumbnail">
							<img id="dj-image" src="/api/dj-image/{{{ $status["dj"]["djimage"] }}}" class="hidden-sm">
							<h4 class="text-center" id="dj-name">{{{ $status["dj"]["djname"] }}}</h4>
						</div>
					</div>
				</div>

			</div><!-- /.row#player -->

		</div><!-- /.container.content -->

	</div><!-- /.container.main -->


	<br>

	<div class="container content">
		<div class="row">
			<div class="col-md-6">
				<h3 class="text-center">{{ trans("stream.lp") }}</h3>
				<ul class="list-group" id="lastplayed">
					@foreach ($lastplayed as $lp)
						<li class="list-group-item last-played" style="overflow-y: auto">
							<div class="col-md-4 lp-time">
								{{ time_ago($lp["time"]) }}
							</div>
							<div class="col-md-8 lp-meta text-center" style="line-height: 1">
								{{{ $lp["meta"] }}}
							</div>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="col-md-6">
				<h3 class="text-center">{{ trans("stream.queue") }}</h3>
				<ul class="list-group" id="queue">
					@foreach ($curqueue as $queue)
						@if ($queue["type"] > 0)
							<li class="list-group-item list-group-item-info queue" style="overflow-y: auto">
						@else
							<li class="list-group-item queue" style="overflow-y: auto">
						@endif
							<div class="col-md-8 text-center q-meta" style="line-height: 1">
								{{{ $queue["meta"] }}}
							</div>
							<div class="col-md-4 text-right q-time">
								{{ time_ago($queue["time"]) }}
							</div>
						</li>
					@endforeach
				</ul>
				<div class="well well-lg" id="dj-mode" style="display: none">
					<h1 class="text-center">Queue Unavailable</h1>
				</div>
			</div>
		</div>

		<div class="row">
			
			@foreach ($news as $article)
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="/news/{{ $article->id }}" class="ajax-navigation">
								<h3 class="panel-title">{{{ $article->title }}} <span class="text-muted pull-right">{{{ $article->author->user }}}</span></h3>
							</a>
						</div>
						<div class="panel-body">
							{{ Markdown::render($article->header) }}
						</div>
					</div>
				</div>
			@endforeach

		</div><!-- /.row -->
	</div><!-- /.container -->
	
@stop

@section('script')

@stop
