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


						@if (Request::segment(1) == "news")
							<li class="active">
						@else
							<li>
						@endif
							<a href="/news" class="ajax-navigation">{{{ trans("navbar.news") }}}</a>
						</li>


						@if (Request::segment(1) == "irc")
							<li class="active">
						@else
							<li>
						@endif
							<a href="/irc" class="ajax-navigation">{{{ trans("navbar.irc") }}}</a>
						</li>


						@if (Request::segment(1) == "search")
							<li class="active">
						@else
							<li>
						@endif
							<a href="/search" class="ajax-navigation">{{{ trans("search.title") }}}</a>
						</li>

						@if (Request::segment(1) == "queue" or Request::segment(1) == "last-played")
							<li class="dropdown active">
						@else
							<li class="dropdown">
						@endif
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Stats <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/last-played" class="ajax-navigation drop">Last Played</a></li>
								<li><a href="/queue" class="ajax-navigation drop">Queue</a></li>
							</ul>
						</li>

						@if (Auth::user() and Auth::user()->canDoPending())
							<li><a href="/admin"><i class="fa fa-star"></i></a></li>
						@endif
					</ul>
					{{ Form::open(['url' => "/search", "class" => "ajax-search navbar-form navbar-right" ]) }}
						<div class="form-group">
							<input type="text" name="q" placeholder="{{{ trans("search.placeholder") }}}" class="form-control" role="search">
						</div>
					{{ Form::close() }}
				</div><!--/.nav-collapse -->
				<div id="stream"></div>
			</div>

			
		</div>
		<noscript>
			<div class="container">
				<div class="alert alert-danger">
					Enable JavaScript or quite a lot of this site is pretty much unusable. (Note: enable HTML5 Storage)
				</div>
			</div>
		</noscript>
		@if (Session::has("status"))
			<div class="container">
				<div class="alert alert-dismissable alert-info">
					<button class="close" data-dismiss="alert">&times;</button>
					{{{ Session::get("status") }}}
				</div>
			</div>
		@endif
