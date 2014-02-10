@section('content')

    <!-- Main Container
    ================ -->
    <div class="container main">

        <!-- Content (Dynamic)
        =================== -->
        <div class="container content">

            <div class="row">

                <!-- Logo 1 (Icon)
                    ============== -->
                <div class="col-md-3">
                    <div class="col-xs-12">
                        <img src="/assets/logo_image_small.png" class="hidden-sm" alt="R/a/dio">
                    </div>
                </div>


                <div class="col-md-6">

                    <div class="row" id="stream-info">

                        <!-- Logo 2 (Branded)
                            ================= -->
                        <div class="col-md-6">
                            <img id="volume-image" src="/assets/logotitle_2.png" alt="R/a/dio" style="width: 100% !important; margin-bottom: 15px;">
                            <div class="well well-sm text-center" style="display: none; margin-bottom: 0;" id="volume-control">
                                <p style="margin-bottom: 10px;">Volume Control</p>
                                <input id="volume" type="range" min="0" max="100" step="1" value="80">
                            </div>
                        </div>

                        <!-- Player Options
                            ================ -->
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-block disabled" id="stream-play" data-loading-text="{{{ trans("stream.loading") }}}"><i class="fa fa-spinner fa-spin"></i></button>
                            <button class="btn btn-primary btn-block" id="stream-stop" data-loading-text="{{{ trans("stream.loading") }}}" style="display: none; margin-top: 0;">{{{ trans("stream.stop") }}}</button>
                            <div class="btn-group btn-block" style="width:100%">
                                <button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">
                                    {{{ trans("stream.options") }}} <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" style="width: 100%">
                                    <li><a href="https://r-a-d.io/main">{{{ trans("stream.links.direct") }}}</a></li>
                                    <li><a href="#">{{{ trans("stream.links.m3u") }}}</a></li>
                                    <li><a href="#">{{{ trans("stream.links.pls") }}}</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/help">{{{ trans("stream.links.help") }}}</a></li>
                                </ul>
                            </div>
                        </div>

                    </div><!-- /.row#stream-info -->

                    <!-- Progress Bar
                        ================= -->
                    <div class="row">

                        <div class="col-xs-12">
                            <h2 class="text-center" id="current-song">
                                <span id="np">
                                    {{{ $status["np"] }}}
                                </span>
                            </h2>
                        </div>

                        <div class="col-xs-12">
                            <div class="progress progress-striped active" id="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted text-center">
                                {{{ trans("stream.listeners") }}}: <span id="listeners">{{{ $status["listeners"] }}}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted text-center">
                                <span id="progress-current">weed</span>
                                /
                                <span id="progress-length">weed</span>
                            </p>
                        </div>


                    </div><!-- /.row#progress -->

                </div>

                <!-- DJ Image + Name
                    ================= -->
                <div class="col-md-3">
                    <div class="col-xs-12">
                        <div class="thumbnail">
                            <img id="dj-image" src="/assets/dj_image.png" class="hidden-xs">
                            <h4 class="text-center" id="dj-name">Hanyuu-sama</h4>
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
                <ul class="list-group text-center" id="lastplayed">
                    @foreach ($lastplayed as $lp)
                        <li class="list-group-item">
                            <div class="container last-played">
                                <div class="col-md-4 lp-time">
                                    {{ time_ago($lp["time"]) }}
                                </div>
                                <div class="col-md-8 lp-meta" style="line-height: 1; height: 30px;">
                                    {{{ $lp["meta"] }}}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <h3 class="text-center">{{ trans("stream.queue") }}</h3>
                <ul class="list-group text-center" id="queue">
                    @foreach ($curqueue as $queue)
                        <li class="list-group-item">
                            <div class="container queue">
                                <div class="col-md-4">
                                    {{ time_ago($queue["time"]) }}
                                </div>
                                <div class="col-md-8" style="line-height: 1; height: 30px;">
                                    @if ($queue["type"] > 0)
                                        <b>{{{ $queue["meta"] }}}</b>
                                    @else
                                        {{{ $queue["meta"] }}}
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row">
            
            @foreach ($news as $article)
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="/news/{{ $article["id"] }}" class="ajax-navigation">
                                <h3 class="panel-title">{{{ $article["title"] }}}</h3>
                            </a>
                        </div>
                        <div class="panel-body">
                            {{ Markdown::render($article["header"]) }}
                        </div>
                    </div>
                </div>
            @endforeach

        </div><!-- /.row -->
    </div><!-- /.container -->
@stop

@section('script')

@stop
