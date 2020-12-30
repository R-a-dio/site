		<!-- Navbar
		======== -->
		<div class="navbar navbar-inverse" style="border-radius: 0px">
			<div class="container navbar-container">

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

						<li>
							<a href="" data-toggle="modal" data-target="#schedule">Schedule</a>
						</li>

						@if (Request::segment(1) == "last-played")
							<li class="active">
						@else
							<li>
						@endif
							<a href="/last-played" class="ajax-navigation">{{{ trans("navbar.lp") }}}</a>
						</li>

						@if (Request::segment(1) == "queue")
							<li class="active">
						@else
							<li>
						@endif
							<a href="/queue" class="ajax-navigation">{{{ trans("navbar.queue") }}}</a>
						</li>

						@if (Request::segment(1) == "faves")
							<li class="active">
						@else
							<li>
						@endif
							<a href="/faves" class="ajax-navigation">{{{ trans("navbar.faves") }}}</a>
						</li>

                                                @if (Request::segment(1) == "staff")
                                                        <li class="active">
                                                @else
                                                        <li>
                                                @endif
                                                        <a href="/staff" class="ajax-navigation">{{{ trans("navbar.staff") }}}</a>
                                                </li>

<!--
						@if (Request::segment(1) == "queue" or Request::segment(1) == "last-played" or Request::segment(1) == "faves")
							<li class="dropdown active">
						@else
							<li class="dropdown">
						@endif
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Stats <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/last-played" class="ajax-navigation drop">Last Played</a></li>
								<li><a href="/queue" class="ajax-navigation drop">Queue</a></li>
								<li><a href="/faves" class="ajax-navigation drop">{{{ trans("faves.title") }}} </a></li>
							</ul>
						</li>
-->
						@if (Request::segment(1) == "submit")
							<li class="active">
						@else
							<li>
						@endif
							<a href="/submit" class="ajax-navigation">{{{ trans("navbar.submit") }}}</a>
						</li>

						@if (Auth::check() and Auth::user()->isActive())
							<li><a href="/admin"><i class="fa fa-star"></i></a></li>
						@endif
					</ul>
					{{ Form::open(['url' => "/search", "class" => "ajax-search navbar-form navbar-right" ]) }}
						<div class="form-group">
							<input type="text" name="q" placeholder="{{{ trans("navbar.request") }}}" class="form-control" role="search">
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
			<div class="container if-container">
				<div class="alert alert-dismissable alert-info">
					<button class="close" data-dismiss="alert">&times;</button>
					@if (is_array(Session::get("status")))
						@foreach (Session::get("status") as $status)
							<p>{{{ $status }}}</p>
						@endforeach
					@else
						<p>{{{ Session::get("status") }}}</p>
					@endif
				</div>
			</div>
		@endif

<div class="modal fade bs-modal-lg" id="schedule">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">R/a/dio Schedule</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-12">
            			<div class="alert-warning alert">
            				Times are in EST. All times and days are subject to change. Any stream can be cancelled without prior notice. If you're wondering if a stream will be held, don't hesitate to ask in chat.
            			</div>
            		</div>
            	</div>
                <div class="row border-between">
                	<div class="col-md-1 h4">{{ Carbon\Carbon::now()->startOfWeek()->format("m/d") }}</div>
			<div class="col-md-2 h4 text-right">Monday</div>
			<div class="col-md-6">
				<p></p><p>Monday music with yukii. Starts around 5PM.<br/>What a boring description.</p>
			</div>
                </div>
                <div class="row border-between">
                    <div class="col-md-offset-1 col-md-2 h4 text-right">Tuesday</div>
                    <div class="col-md-6">
                    	<p></p><p>Touhou Tuesday with Kethsar, where the same song is played 10 times in one stream. Starts between 6 and 9PM except when Keth's sleep schedule is fucked, which is 99% of the time.</p>
                    </div>
                </div>
                <div class="row border-between">
                    <div class="col-md-offset-1 col-md-2 h4 text-right">Wednesday</div>
                    <div class="col-md-6">
                    	<p></p><p><strike>Master Bacon</strike> Autistic weeb plays musical memes. Usually starting around 11PM or midnight.</p>
                    </div>
                </div>
                <div class="row border-between">
                    <div class="col-md-offset-1 col-md-2 h4 text-right">Thursday</div>
                    <div class="col-md-6">
                    	<p></p><p>The Indie Feature, with apt-get. Discover the bands and artists that have shaped Japan's music then and now, whether booming or underground. Stars around 2PM.</p>
                    </div>
                </div>
                <div class="row border-between">
                    <div class="col-md-offset-1 col-md-2 h4 text-right">Friday</div>
                    <div class="col-md-6">
                    	<p></p><p>Friday Night Faggotry! ed usually starts off at 2 PM with open requests, if he is around. One of various DJs will take over at 8PM. Occasionally guest DJs will stream instead (apply today!).</p>
                    </div>
                </div>
                <div class="row border-between">
                    <div class="col-md-offset-1 col-md-2 h4 text-right">Saturday</div>
                    <div class="col-md-6">
                    	<p></p><p>Join Yorozuya as he livemixes anison, sometimes anison remixes, every other week to your disdain.<br/>Alternating with him is our bartending goose, Claud.<br/>Frankly, no one is able to remember whose week is whose anymore.</p>
                    </div>
                </div>
                <div class="row border-between">
                    <div class="col-md-offset-1 col-md-2 h4 text-right">Sunday</div>
                    <div class="col-md-6">
                    	<p></p><p>Weekly Wildcard Block with McDoogle between 7 and 11 PM! Tune in to see what he has in store!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

