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
						<li><a href="/irc" class="ajax-navigation">{{{ trans("navbar.irc") }}}</a></li>
					</ul>
					{{ Form::open(['url' => "/search", "class" => "navbar-form navbar-right" ]) }}
						<div class="form-group">
							<input type="text" name="q" placeholder="{{{ trans("search.placeholder") }}}" class="form-control" role="search">
						</div>
					{{ Form::close() }}
				</div><!--/.nav-collapse -->
				<div id="stream"></div>
			</div>

			
		</div>