		<!-- Navbar
		======== -->
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">

				<!-- Collapse Icon
				======== -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ $base }}/admin"><img src="{{ $base }}/assets/logotitle_2.png" height="22"></a>
				</div>

				<!-- Navbar Itself
				======== -->
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="{{ $base }}/admin">Home</a></li>
						<li><a href="{{ $base }}/news">News</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Songs <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ $base }}/admin/pending">Pending</a></li>
								<li><a href="{{ $base }}/admin/songs">Current</a></li>
							</ul>
						</li>

						<li><a href="{{ $base }}/admin/users">Users</a></li>
						<li><a href="{{ $base }}/admin/djs">DJs</a><li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hiroto <span class="badge">42</span></a>
						<ul class="dropdown-menu">
							<li><a href="{{ $base }}/admin/notifications">Site's broken again</a></li>
							<li><a href="{{ $base }}/admin/notifications">Someone called Yuru Yuri bad again</a></li>
							<li><a href="{{ $base }}/admin/pending">150 Pending Songs</a></li>
							<li><a href="{{ $base }}/admin/errors">15 New Errors</a></li>
							<li><a href="{{ $base }}/admin/users">2 New Users Registered</a></li>
							<li><a href="{{ $base }}/admin/notifications">37 More...</a></li>
						</ul>
						</li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{{ $base }}/admin/edit-profile">Edit</a></li>
							<li><a href="{{ $base }}/admin/dj-profile">DJ Profile</a></li>
							<li><a href="{{ $base }}/admin/change-password">Change Password</a></li>
							<li><a href="{{ $base }}/admin/logout">Log Out</a></li>
						</ul>
						</li>
					</ul>
					
				</div><!--/.nav-collapse -->

			</div>
		</div>
