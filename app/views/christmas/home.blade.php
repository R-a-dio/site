@section('content')
<div class="snow" id="Div1"></div> <!-- This is for the snow.js -->
<!-- Main Container
	================ -->
<div class="container main">
	<!-- Content (Dynamic)
		=================== -->
	<div class="container top-pusher">
	</div>
	<div class="col-md-2"></div>
	<div class="col-md-8 content upper-content">
		<div class="row dynamic-row">
			<!-- DJ Image + Name
				================= -->
			<div class="col-md-12">
				@include("partials.dj-image")
			</div>
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				@include("partials.volume-logo")
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
						@if (!$cur_theme)
						<li class="active"><a href="/set-theme/-1">Use DJ Theme</a></li>
						@else
						<li><a href="/set-theme/-1">Use DJ Theme</a></li>
						@endif
						@foreach ($themes as $t)
						@if ($t->name === $cur_theme)
						<li class="active"><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></li>
						@else
						<li><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></li>
						@endif
						@endforeach
						<li class="divider"></li>
						<li><a href="#help" data-toggle="modal" data-target="#help">{{{ trans("stream.links.help") }}}</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-4"></div>
			<div class="row progress-row">
				<div class="col-xs-12">
					@include("partials.now-playing")
				</div>
				<div class="col-md-3"></div>
				<div class="col-md-3">
					<p class="text-muted text-center listeners-num">
						@include("partials.listeners")
					</p>
				</div>
				<div class="col-md-3">
					<p class="text-muted text-center timer-num">
						@include("partials.timer")
					</p>
				</div>
				<div class="col-md-2"></div>
			</div>
			<!-- /.row#progress -->
			<div class="col-md-12 hidden-xs hidden-sm">
				<div class="row lists-row">
					<div class="col-md-12">
						<ul class="list-group" id="lastplayed">
							@foreach (array_slice($lastplayed, 0, 3) as $lp)
							<li class="list-group-item last-played" style="overflow-y: auto">
								<div class="col-md-12 lp-meta text-center" style="line-height: 1">
									{{{ $lp["meta"] }}}
								</div>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3"></div>
</div>
</div><!-- /.row#player -->
</div><!-- /.container.content -->
</div><!-- /.container.main -->
</div>
@stop
@section('script')
@stop
