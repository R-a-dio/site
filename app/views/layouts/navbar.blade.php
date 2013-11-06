		<!-- Navbar
		======== -->
		<div class="navbar navbar-inverse">
			<div class="container">

				<!-- Collapse Icon
				======== -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand active" href="{{ $base }}/"><img src="{{ $base }}/assets/logotitle_2.png" height="22"></a>
				</div>

				<!-- Navbar Itself
				======== -->
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="{{ $base }}/news">{{{ trans("navbar.news") }}}</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{{ trans("navbar.data") }}} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ $base }}/last-played">{{{ trans("navbar.lp") }}}</a></li>
								<li><a href="{{ $base }}/queue">{{{ trans("navbar.queue") }}}</a></li>
								<li><a href="{{ $base }}/faves">{{{ trans("navbar.faves") }}}</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{{ trans("navbar.stats") }}} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ $base }}/stats">{{{ trans("navbar.graphs") }}}</a></li>
								<li><a href="{{ $base }}/staff">{{{ trans("navbar.staff") }}}</a></li>
							</ul>
						</li>

						<li><a href="{{ $base }}/submit">{{{ trans("navbar.submit") }}}</a></li>
						<li><a href="{{ $base }}/irc">{{{ trans("navbar.irc") }}}</a></li>
					</ul>
					{{ Form::open(['url' => $base . "/search", "class" => "navbar-form navbar-right" ]) }}
						<div class="form-group">
							<input type="text" name="q" placeholder="{{{ trans("search.placeholder") }}}" class="form-control" role="search">
						</div>
					{{ Form::close() }}
				</div><!--/.nav-collapse -->
				<audio src="https://r-a-d.io/main" preload="metadata" id="player"></audio>
			</div>

			
		</div>