@section('content')

	<!-- Main Container
	================ -->
	<div class="container main">

		<!-- Content (Dynamic)
		=================== -->
		@include("partials.help-main")
		<div class="container content top-content">

			<div class="row dynamic-row">

				<!-- Logo 1 (Icon)
					============== -->
				<div id="logo-image-container" class="col-md-3 hidden-xs hidden-sm">
					<div class="col-xs-12">
						<img src="/assets/logo_image_small.png" alt="R/a/dio">
					</div>
				</div>


				<div class="col-md-6">

					<div class="row info-row" id="stream-info">

						<!-- Logo 2 (Branded)
							================= -->
						<div class="col-md-6">
							@include("partials.volume-logo")
						</div>

						<!-- Player Options
							================ -->
						<div class="col-md-6">
							@include("partials.player-options")
						</div>

					</div><!-- /.row#stream-info -->

					<!-- Progress Bar
						================= -->
					<div class="row progress-row">

						<div class="col-xs-12">
							@include("partials.now-playing")
						</div>

						<div class="col-xs-12">
							@include("partials.progress-bar")
						</div>

						<div class="col-md-6">
							<p class="text-muted text-center">
								@include("partials.listeners")
							</p>
						</div>
						<div class="col-md-6">
							<p class="text-muted text-center">
								@include("partials.timer")
							</p>
						</div>


					</div><!-- /.row#progress -->

				</div>

				<!-- DJ Image + Name
					================= -->
				<div id="dj-image-container" class="col-md-3">
					<div class="col-xs-12">
						@include("partials.dj-image")
					</div>
				</div>

			</div><!-- /.row#player -->

		</div><!-- /.container.content -->

	</div><!-- /.container.main -->


	<br>

	<div class="container content middle-content">
		<div class="row lists-row">
			<div class="col-md-6">
				@include("partials.last-played", ["count" => 5])
			</div>
			<div class="col-md-6">
				@include("partials.queue", ["count" => 5])
				@include("partials.thread")
			</div>
		</div>

		@include("partials.news", ["count" => 3])
	</div><!-- /.container -->
	
@stop

@section('script')

@stop
