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
				@include("partials.player-options")
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
			@include("partials.thread")
		</div>
	</div>
	<div class="col-md-3"></div>
</div>
</div><!-- /.row#player -->
</div><!-- /.container.content -->
</div><!-- /.container.main -->
</div>
<style>
	#dj-mode h2 {
		background: rgba(24,32,36,0.4);
		background: radial-gradient(at bottom,
			rgba(24,32,36,0.4),
			rgba(24,32,36,0) 60%
		);
		box-shadow: 0 .2em .2em -.2em hsla(212, 60%, 20%, 0.3);
	}
	.lp-meta.text-center, .listeners-num, .timer-num {
		text-shadow: .03em .03em .01em #012;
	}
	#np, #dj-mode h2, #dj-mode h1 a {
		text-shadow: .02em .02em .04em #012;
	}
</style>
@stop
@section('script')
@stop
