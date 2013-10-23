		<!-- Navbar
		======== -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">

				<!-- Collapse Icon
				======== -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand active" href="{{ $base }}"><img src="{{ $base }}/assets/logotitle_2.png" height="22"></a>
				</div>

				<!-- Navbar Itself
				======== -->
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li id="nav-control" class="hidden-xs"><a href="#" ><i class="icon-play"></i></a></li>

						<li><a href="{{ $base }}/news">News</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Play Data <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ $base }}/last-played">Last Played</a></li>
								<li><a href="{{ $base }}/queue">Queue</a></li>
								<li><a href="{{ $base }}/faves">Favourites</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Stats <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ $base }}/stats/graphs">Graphs &amp; Metrics</a></li>
								<li><a href="{{ $base }}/stats/djs">Staff</a></li>
								<li><a href="{{ $base }}/stats/faves">Favourites</a></li>
							</ul>
						</li>

						<li><a href="{{ $base }}/submit">Submit</a></li>
						<li><a href="{{ $base }}/irc">IRC</a></li>
					</ul>
					{{ Form::open(['url' => $base . "/search", "class" => "navbar-form navbar-right" ]) }}
						<div class="form-group">
							<input type="text" name="q" placeholder="Search" class="form-control" role="search">
						</div>
					{{ Form::close() }}
				</div><!--/.nav-collapse -->
				<span style="display: none" id="stream-container" data-var="stopped">

				</span>
			</div>

			
		</div>
