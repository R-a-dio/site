@extends('master')

@section('content')

        <!-- Main Container
        ================ -->
        <div class="container main">
            <div id="visualisation"></div>

            <!-- Content (Dynamic)
            =================== -->
            <div class="container content">

                <div class="row">

                    <!-- Logo 1 (Icon)
                        ============== -->
                    <div class="col-md-3">
                        <div class="col-xs-12">
                            <img src="{{ $base }}/assets/logo_image_small.png" class="hidden-xs" alt="R/a/dio">
                        </div>
                    </div>


                    <div class="col-md-6">

                        <div class="row" id="stream-info">

                            <!-- Logo 2 (Branded)
                                ================= -->
                            <div class="col-md-6">
                                <img src="{{ $base }}/assets/logotitle_2.png" width="100% !important; margin-bottom: 25px" class="hidden-xs" alt="R/a/dio">

                            </div>

                            <!-- Player Options
                                ================ -->
                            <div class="col-md-6">
                                <a class="btn btn-primary btn-block" href="#" id="stream-player" data-loading-text="{{{ trans("stream.loading") }}}">{{{ trans("stream.play") }}}</a>
                                <div class="btn-group btn-block" style="width:100%">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">
                                        {{{ trans("stream.options") }}} <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="width: 100%">
                                        <li id="stream-volume"> 
                                            <input type="range">
                                        </li>
                                        <li><a href="https://r-a-d.io/main">{{{ trans("stream.links.direct") }}}</a></li>
                                        <li><a href="#">{{{ trans("stream.links.m3u") }}}</a></li>
                                        <li><a href="#">{{{ trans("stream.links.pls") }}}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{ $base }}/help">{{{ trans("stream.links.help") }}}</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-info btn-block" id="loading">DEBUG: Audio Not Loaded</button>
                            </div>

                        </div><!-- /.row#stream-info -->

                        <!-- Progress Bar
                            ================= -->
                        <div class="row" id="progress">

                            <div class="col-xs-12">
                                <h2 class="text-center" id="current-song">
                                    <span id="song-artist">
                                        Tripflag
                                    </span>
                                         -
                                    <span id="song-title">
                                        OnkelSaft
                                    </span>
                                </h2>
                            </div>

                            <div class="col-xs-12">
                                <div class="progress" id="stream-progress-bar">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <p class="text-muted text-center">
                                    {{{ trans("stream.listeners") }}}: <span id="listeners">420</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted text-center">
                                    <span id="progress-current">weed</span>
                                    /
                                    <span id="progress-total">05:24</span>
                                </p>
                            </div>


                        </div><!-- /.row#progress -->

                    </div>

                    <!-- DJ Image + Name
                        ================= -->
                    <div class="col-md-3">
                        <div class="col-xs-12">
                            <div class="thumbnail">
                                <img src="{{ $base }}/assets/dj_image.png" class="hidden-xs">
                                <h4 class="text-center">Hanyuu-sama</h4>
                            </div>
                        </div>
                    </div>

                </div><!-- /.row#player -->

            </div><!-- /.container.content -->

        </div><!-- /.container.main -->


        <br>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-center">{{ trans("stream.lp") }}</h3>
                    <ul class="list-group text-center">
                        {{ $lp }}
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3 class="text-center">{{ trans("stream.queue") }}</h3>
                    <ul class="list-group text-center">
                        {{ $queue }}
                    </ul>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">It's fucking nothing.</h3>
                        </div>
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Something about news.</h3>
                        </div>
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Something else!</h3>
                        </div>
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container -->
@stop

@section('script')
    <script>
    $("#stream-player").click(function(event) {
        event.preventDefault();

        $("#player").get()[0].play();
    })
    </script>
@stop
