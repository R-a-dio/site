@section('content')
<!-- Main Container
	================ -->
<div class="container main" style="z-index:-1;">
<div id="logo-image-container" style="position:absolute;top:10px;left:calc(100vw - 60px);padding:0px;margin:0px;width:50px;height:50px;z-index:1;">
	<div>
		<span style="position: absolute;color: #fff;right: 60px;line-height: 25px;font-size: 25px;width: auto;overflow: hidden;"><a href="https://r-a-d.io/news/71" style="color:#fff;">xmas schedule</a></span>
		<img src="/assets/logo_image_small_christmas.png" alt="R/a/dio" style="height:50px;z-index:1;">
	</div>
</div>
<div style="position:absolute;top:10px;left:10px;padding:0px;margin:0px;width:50px;height:50px;z-index:1;">
	@if (Auth::check() and Auth::user()->isActive())
		<a href="/admin"><i class="fa fa-star" style="font-size:50px;"></i></a>
	@endif
</div>
	<!-- Content (Dynamic)
		=================== -->
	@include("partials.help-main")
	@include("partials.preferences")

	<div class="col-md-2"></div>
	<div class="col-md-8 content upper-content" style="z-index:1;">
		<div class="row dynamic-row">
			<!-- DJ Image + Name
				================= -->
			<div class="col-md-12">
				<!-- @include("partials.dj-image") -->
			<div class="thumbnail">
			        <img id="dj-image" src="/api/dj-image/{{{ $status["dj"]["djimage"] }}}" class="hidden-sm img-rounded" style="max-height: 180px">
			        <h4 class="text-center" id="dj-name">{{{ $status["dj"]["djname"] }}}</h4>
			</div>

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
