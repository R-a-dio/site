@extends('master')

@section('content')

        <!-- Main Container
        ================ -->
        <div class="container main">


            <!-- Content (Dynamic)
            =================== -->
            <div class="container content">

                <div class="row" id="player">

                    <!-- Logo 1 (Icon)
                        ============== -->
                    <div class="col-md-3">
                        <div class="col-xs-12">
                            <img src="{{ $base }}/assets/logo_image_small.png" class="hidden-xs">
                        </div>
                    </div>


                    <div class="col-md-6">

                        <div class="row" id="stream-info">

                            <!-- Logo 2 (Branded)
                                ================= -->
                            <div class="col-md-6">
                                <img src="{{ $base }}/assets/logotitle_2.png" width="100% !important; margin-bottom: 25px" class="hidden-xs">

                            </div>

                            <!-- Player Options
                                ================ -->
                            <div class="col-md-6">
                                <a class="btn btn-primary btn-block" href="#" id="stream-player" data-loading-text="Loading...">Play Stream</a>
                                <div class="btn-group btn-block" style="width:100%">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">
                                        More Options <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style="width: 100%">
                                        <li id="stream-volume"> 
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li><a href="https://r-a-d.io/R-a-dio">Direct Stream Link</a></li>
                                        <li><a href="#">Stream .m3u File</a></li>
                                        <li><a href="#">Stream .pls File</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{ $base }}/help">Help</a></li>
                                    </ul>
                                </div>
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
                                    Listeners: <span id="listeners">420</span>
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
                    <h3 class="text-center">Last Played</h3>
                    <ul class="list-group text-center">
                        {{ $lp }}
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3 class="text-center">Queue</h3>
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
    $(function() {
        function createStream() {
            console.log('creating new element');

            // the only way to flush the audio buffer is to re-create the element.
            $('<audio id="stream" src="https://r-a-d.io/main" preload="auto">Get a better bloody browser.</audio>').appendTo('#stream-container');

            // event handler for audio loading
            $('#stream').on('loadeddata', function() {
                console.log('loadeddata fired');
                $('#stream-player').html('Stop Stream');
            });

            $('#stream').on('canplay', function() {
                console.log('attempting to play the stream...');
                document.getElementById('stream').play();
            });

            // error logging
            $('#stream').on('error', function(event) {
                console.log(event);
            });

            $('#stream').on('waiting', function(event) {
                console.log('waiting... ' + event);
            });

            // Show the volume slider
            $('#stream-volume').show();

        }

        function stopStream() {
            // initially pause the element to stop audio
            document.getElementById('stream').pause();
            document.getElementById('stream').currentTime = 0;
            document.getElementById('stream').load();
            
            // Hide the volume slider now that we're done with it.
            $('#stream-volume').hide();

            // destroy the element, removing it from the DOM
            $('#stream').remove();
            $('#stream-container').attr('data-var', 'stopped');
      
        }

        function playStream() {
            createStream();
            // force a load 
            
            $('#stream-container').attr('data-var', 'playing');
        }

        $('#stream-player').click(function(event) {

            // prevent url changing to /#
            event.preventDefault();

            // grab state for below
            var state = $('#stream-container').attr('data-var');

            if (state == "stopped") {
                console.log('playing stream');
                $(this).html('<div class="progress progress-striped active" style="width: 80%; margin-left: auto; margin-right: auto; margin-bottom: 0;"><div class="progress-bar progress-bar-info" role="progressbar" style="width: 100%"></div></div>');
                playStream();
            }
            if (state == "playing") {
                console.log('stopping stream');
                $(this).html('Play Stream');
                stopStream();
            }
        });
    });
    </script>
@stop
