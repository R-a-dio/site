@section('content')

<!-- this is desktop site -->

<div class="pagecont hidden-xs hidden-sm">
	<div class="container midvert">
		<div class="row">
	
				<!-- stream stuff panel -->
	
				<div class="col-md-8 number1">
					<div class="img1">
						
						<div class="col-md-12 minusonefourth nopadding">
							<div class="col-md-12 minusonefourth margins1 colorfill nopadding"> 
								<div class="col-md-12 nominus themes nopadding">
									@if (!$cur_theme)
										<div class="themeslist"><a href="/set-theme/-1">Use DJ Theme</a></div>
									@else
										<div class="themeslist"><a href="/set-theme/-1">Use DJ Theme</a></div>
									@endif
									@foreach ($themes as $t)
										@if ($t->name === $cur_theme)
											<div class="themeslist"><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></div>
										@else
											<div class="themeslist"><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></div>
										@endif
									@endforeach
								</div>
								
								<div class="col-md-12 players">
						<div class="col-md-12">
							<div class="well well-sm text-center temporaryname" style="display: none; margin-bottom: 0;" id="volume-control">
								<p style="margin-bottom: 10px;">Volume Control</p>
								<input id="volume" type="range" min="0" max="100" step="1" value="80">
							</div>
						</div>
								<button class="btn btn-primary btn-block disabled" id="stream-play" data-loading-text="{{{ trans("stream.loading") }}}"><i class="fa fa-spinner fa-spin"></i></button>
								<button class="btn btn-primary btn-block" id="stream-stop" data-loading-text="{{{ trans("stream.loading") }}}" style="display: none; margin-top: 0;">{{{ trans("stream.stop") }}}</button>
								</div>
							
							<div class="col-md-12 listens nopadding">
									<div class="streamlist"><a href="https://stream.r-a-d.io/main.mp3">{{{ trans("stream.links.direct") }}}</a></div>
									<div class="streamlist"><a href="/assets/main.mp3.m3u">{{{ trans("stream.links.m3u") }}}</a></div>
									<div class="streamlist"><a href="/assets/main.pls">{{{ trans("stream.links.pls") }}}</a></div>
							</div>
							
							<div id="ghosts" class="col-md-12 loadings nopadding">
							<img src="/images/cysmix/Ghost.gif" class="cysm-load"><img src="/images/cysmix/Ghost.gif" class="cysm-load"><img src="/images/cysmix/Ghost.gif" class="cysm-load">
							</div>
							
							</div>
							
						</div>
						
						

					
					<div id="progress">
						<div class="col-md-12 nopadding np-underlay npbar onefourth texturefill progress" role="progressbar" style="width: 100%"></div>
					</div>
						
					<div class="col-md-12 nopadding np-container colorfill onefourth">

						
							<div class="col-md-2 nopadding middletext nowplaying">
								<div class="centertext">
									<h4 class="lel">NP:</h4>
								</div>
							</div>
	
								<div class="col-md-8 nopadding middletext nowplaying">
									<div class="">
										<span id="np" class="np"><h4>
											{{{ $status["np"] }}}
										</h4></span>
									</div>
								</div>
								
								<div class="col-md-2 nopadding middletext nowplaying">
									<div class="centertext">
										<h4 class="text-muted text-center">
											{{{ trans("stream.listeners") }}}: <span id="listeners">{{{ $status["listeners"] }}}</span>
										</h4>
									</div>
								</div>
							
					</div>
					
					</div>
				</div>
  
				<!-- row separator (not sure if need) -->
  
				<div class="col-md-12 hidden-lg hidden-md rowseparator">
				</div>
				
				<!-- buttons -->
  
				<div class="col-md-1 number9 nopadding colorfill buttoncontainers visible-lg">
					<div class="col-md-12 nopadding onethird first abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 listenbutton">listen</h3>
							</div>
						</div>
  
					</div>
  
					<div class="col-md-12 nopadding onethird abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 themebutton">theme</h3>
							</div>
						</div>
					</div>
  
					<div class="col-md-12 nopadding onethird abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 playerbutton">player</h3>
							</div>
						</div>
					</div>
  
					<div class="col-md-12 nopadding onethird abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 helpbutton">help</h3>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-1 number9 nopadding colorfill buttoncontainers visible-md">
					<div class="col-md-12 nopadding onethird first abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 listenbutton">lsn</h3>
							</div>
						</div>
  
					</div>
  
					<div class="col-md-12 nopadding onethird abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 themebutton">thm</h3>
							</div>
						</div>
					</div>
  
					<div class="col-md-12 nopadding onethird abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 playerbutton">plr</h3>
							</div>
						</div>
					</div>
  
					<div class="col-md-12 nopadding onethird abutton">
						<div class="img2">
							<div class="centertext">
								<h3 class="lel4 helpbutton">hlp</h3>
							</div>
						</div>
					</div>
				</div>
				
				<!-- dj image -->
				
                <div class="col-md-3 number8 fixpadding">
					<div class="img2 minusnone">
						<div class="col-md-12 minusonefourth colorfill nopadding">
								<img id="dj-image" src="/api/dj-image/{{{ $status["dj"]["id"] }}}" class="hidden-sm img-rounded col-md-12" style="max-height: 180px">
						</div>
						
						<div class="col-md-12 nopadding onefourth colorfill topmargin">
							<div class="">
								<h3 class="text-center" id="dj-name">{{{ $status["dj"]["djname"] }}}</h3>
							</div>        
						</div>
					</div>
				</div>

				<!-- row separator (not sure if need) -->
				
				<div class="col-md-12 invisible rowseparator"></div>
				
				<!-- news -->
	
				<div class="row">
					<div class="col-md-4 number3 nopadding">
							
							@foreach ($news as $article)

									<div class="img3 news-conts">
										<div class="col-md-12 newstitle nopadding colorfill">
											<a href="/news/{{ $article->id }}" class="ajax-navigation">
												<h4 class="lel5 titlemargins">{{{ $article->title }}} <span class="text-muted pull-right hidden">~{{{ $article->author->user }}}</span></h4>
											</a>
										</div>
										<div class="col-md-12 newscontent nopadding colorfill">
											<div class="newspadding">{{ Markdown::render($article->header) }}</div>
										</div>
									</div>

							@endforeach
							
						<!-- </div> -->
					</div>
				
				<!-- last played -->
				
					<div class="col-md-8 number2 nopadding">
						<div class="img4">
							<div class="col-md-12 lptitle nopadding colorfill">
								<div class="centertext">
									<h4 class="lel5 titlemargins">Last Played</h4>
								</div>
							</div>
							
  
							<div class="col-md-12 colorfill lpcontent">
					@foreach ($lastplayed as $lp)
							<div class="col-md-10  nopadding">
								<p class="lel7">{{{ $lp["meta"] }}}</p>
							</div>
							<div class="col-md-2  nopadding">
								<p class="lel8">{{ time_ago($lp["time"]) }}</p>
							</div>
					@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
					<div class="container colorfill helps">
						<div class="modal bs-modal-lg" id="help">
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
										<button type="button" class="btn btn-default stophelp" data-dismiss="modal">Close</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					</div>
</div>

<div class="hidden-lg hidden-md">
<h1>mobile site coming sometime in 2020</h1>
<div class="streamlist"><a href="https://stream.r-a-d.io/main.mp3">{{{ trans("stream.links.direct") }}}</a></div>
<div class="streamlist"><a href="/assets/main.mp3.m3u">{{{ trans("stream.links.m3u") }}}</a></div>
<div class="streamlist"><a href="/assets/main.pls">{{{ trans("stream.links.pls") }}}</a></div>
</div>
<!-- end -->

@stop

@section('script')

@stop
