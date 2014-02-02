		<!-- Navbar
		======== -->
		<div class="navbar navbar-default">
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
						<li class="active"><a href="/admin">Home</a></li>
						<li><a href="/news">News</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Songs <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/admin/pending">Pending</a></li>
								<li><a href="/admin/songs">Current</a></li>
							</ul>
						</li>

						<li><a href="/admin/users">Users</a></li>
						<li><a href="/admin/djs">DJs</a><li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hiroto <span class="badge">42</span> <span class="badge errors">15</span> <span class="badge pending">150</span></a>
						<ul class="dropdown-menu">
							<li class="dropdown-header">Notifications</li>
							<li><a href="/admin/notifications">Site's broken again</a></li>
							<li><a href="/admin/notifications">Someone called Yuru Yuri bad again</a></li>
							<li><a href="/admin/users">2 New Users Registered</a></li>
							<li class="divider"></li>
							<li><a href="/admin/errors"><span class="badge errors">15</span> New Errors</a></li>
							<li><a href="/admin/pending"><span class="badge pending">150</span> Pending Songs</a></li>
							<li><a href="/admin/notifications"><span class="badge">37</span> More...</a></li>
						</ul>
						</li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/admin/edit-profile">Edit</a></li>
							<li><a href="/admin/dj-profile">DJ Profile</a></li>
							<li><a href="/admin/change-password">Change Password</a></li>
							<li><a href="/admin/logout">Log Out</a></li>
						</ul>
						</li>
					</ul>
					
				</div><!--/.nav-collapse -->

			</div>
		</div>
		<div class="container">
			@if (Session::has("status"))
				<div class="alert alert-dismissable alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Markdown::render(Session::get("status")) }}
				</div>
			@endif
		</div>
