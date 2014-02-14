		<!-- Navbar
		======== -->
		<div class="navbar navbar-default" style="border-radius: 0px">
			<div class="container">

				<!-- Collapse Icon
				======== -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/admin"><img src="/assets/logotitle_2.png" height="22"></a>
				</div>

				<!-- Navbar Itself
				======== -->
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li
							@if (!Request::segment(2))
								class="active"
							@endif
						><a href="/admin">Home</a></li>
						<li
							@if (Request::segment(2) == "news")
								class="active"
							@endif
						>
							<a href="/admin/news">News</a>
						</li>

						<li
							@if (Request::segment(2) == "pending" or Request::segment(2) == "songs")
								class="dropdown active"
							@else
								class="dropdown"
							@endif
						>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Songs <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/admin/pending">Pending</a></li>
								<li><a href="/admin/songs">Current</a></li>
							</ul>
						</li>

						<li
							@if (Request::segment(2) == "users")
								class="active"
							@endif
						><a href="/admin/users">Users</a></li>
						<li
							@if (Request::segment(2) == "djs")
								class="active"
							@endif
						><a href="/admin/djs">DJs</a><li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{{ Auth::user()->user }}} <span class="badge">{{{ $notifications->count() }}}</span> <span class="badge errors"></span> <span class="badge pending"></span></a>
						<ul class="dropdown-menu">
							<li class="dropdown-header">Notifications</li>
							@foreach ($notifications as $notification)
								<li><a href="/admin/notifications">
									{{ $notification["notification"] }}
								</a></li>
							@endforeach
							<li class="divider"></li>
							<li><a href="/admin/errors"><span class="badge errors">0</span> Errors</a></li>
							<li><a href="/admin/pending"><span class="badge pending">0</span> Pending Songs</a></li>
							<li><a href="/admin/notifications"><span class="badge">{{ $notifications->count() }}</span> Notifications</a></li>
						</ul>
						</li>
						<li
							@if (Request::segment(2) == "profile")
								class="dropdown active"
							@else
								class="dropdown"
							@endif
						>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/admin/profile">Edit Profile</a></li>
							@if (Auth::user()->isDJ())
								<li><a href="/admin/profile#dj">DJ Profile</a></li>
							@endif
							<li><a href="/admin/profile#password">Change Password</a></li>
							<li><a href="/logout">Log Out</a></li>
						</ul>
						</li>
					</ul>
					
				</div><!--/.nav-collapse -->

			</div>
		</div>
		<noscript>
			<div class="container">
				<div class="alert alert-danger">
					Why in the shit do you have NoScript on. Also everything depends on jQuery.
				</div>
			</div>
		</noscript>
		<div class="container">
			@if (Session::has("status"))
				<div class="alert alert-dismissable alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Markdown::render(Session::get("status")) }}
				</div>
			@endif
		</div>
