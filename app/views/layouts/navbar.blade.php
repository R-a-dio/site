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
					<a class="navbar-brand ajax-navigation" href="/"><img src="/assets/logotitle_2.png" height="22"></a>
				</div>

				<!-- Navbar Itself
				======== -->
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="/news" class="ajax-navigation">{{{ trans("navbar.news") }}}</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{{ trans("navbar.data") }}} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/last-played" class="ajax-navigation">{{{ trans("navbar.lp") }}}</a></li>
								<li><a href="/queue" class="ajax-navigation">{{{ trans("navbar.queue") }}}</a></li>
								<li><a href="/faves" class="ajax-navigation">{{{ trans("navbar.faves") }}}</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{{ trans("navbar.stats") }}} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/stats" class="ajax-navigation">{{{ trans("navbar.graphs") }}}</a></li>
								<li><a href="/staff" class="ajax-navigation">{{{ trans("navbar.staff") }}}</a></li>
							</ul>
						</li>

						<li><a href="/submit" class="ajax-navigation">{{{ trans("navbar.submit") }}}</a></li>
						<li><a href="/irc" class="ajax-navigation">{{{ trans("navbar.irc") }}}</a></li>
					</ul>
					{{ Form::open(['url' => "/search", "class" => "navbar-form navbar-right" ]) }}
						<div class="form-group">
							<input type="text" name="q" placeholder="{{{ trans("search.placeholder") }}}" class="form-control" role="search">
						</div>
					{{ Form::close() }}
				</div><!--/.nav-collapse -->
				<audio src="https://r-a-d.io/main" preload="metadata" id="player"></audio>
			</div>

			
		</div>