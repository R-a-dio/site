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
                    <a class="navbar-brand" href="#/home"><img src="./assets/logotitle_2.png" height="22"></a>
                </div>

                <!-- Navbar Itself
                ======== -->
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="/news">News</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Play Data <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#/last-played">Last Played</a></li>
                                <li><a href="#/queue">Queue</a></li>
                                <li><a href="#/faves">Favourites</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Stats <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="stats/graphs">Graphs &amp; Metrics</a></li>
                                <li><a href="stats/djs">Staff</a></li>
                                <li><a href="stats/faves">Favourites</a></li>
                            </ul>
                        </li>

                        <li><a href="#/submit">Submit Songs</a></li>
                    </ul>
                    <form class="navbar-form navbar-right">
                        <div class="form-group">
                            <input type="text" placeholder="Search" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Request</button>
                    </form>
                </div><!--/.nav-collapse -->

            </div>
        </div>