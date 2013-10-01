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
						<li><a href="#">Hiroto <span class="badges">42</span></a></li>
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Profile <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Edit</a></li>
							<li><a href="#">DJ Profile</a></li>
							<li><a href="#">Change Password</a></li>
							<li><a href="#">Log Out</a></li>
						</ul>
						</li>
					</ul>
					
				</div><!--/.nav-collapse -->

			</div>
		</div>
