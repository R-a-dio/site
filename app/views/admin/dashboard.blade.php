@section('content')
	<div class="container main">
		<div class="col-md-4">
			<div class="well">
				@if (Auth::user()->isDev())
					<div class="well errors">
						<h3>{{{ $notifications["errors"] }}} Error Messages.</h3>
						<p>The last one was <a href="#">x mins ago</a></p>
						<p class="text-center"><a href="/admin/errors" class="btn btn-info">Reset Error Counter</a></p>
					</div>
				@endif
				<div class="well pending">
					<h3>{{{ $notifications["pending"] }}} Pending Song(s).</h3>
					<p>The last accepted song was <a href="#">x mins ago</a></p>
					<p class="text-center"><a href="/admin/pending" class="btn btn-danger">View Pending</a>

				</div>
				<div class="well">
					<h3>{{{ $notifications["events"] }}} Events</h3>
					<p>These are mostly for admins, but occasionally there's a global announce.</p>
					<p class="text-center"><a href="/admin/notifications" class="btn btn-success">View Events</a></p>
				</div>
				<div class="well">
					<h3>Daypass</h3>
					<p>Today's daypass is: <span class="label label-primary">{{{ daypass() }}}</span></p>
					<p>Hand it out with discretion!</p>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel-group" id="accordion">

				@foreach ($news as $article)
					@if ($article["private"])
						<div class="panel panel-info">
					@else
						<div class="panel panel-default">
					@endif
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-news-{{{ $article["id"] }}}">
									{{{ $article["title"] }}} <span class="pull-right text-muted">{{{ User::find($article["user_id"])->user }}}</span>
								</a>
							</h4>
						</div>
						<div id="collapse-news-{{{ $article["id"] }}}" class="panel-collapse collapse">
							<div class="panel-body">
								<span class="date text-muted">
									{{{ $article["created_at"] }}}
									@if ($article["updated_at"])
										(updated: {{{ $article["updated_at"] }}})
									@endif
								</span>
								{{ Markdown::render($article["text"]) }}
								<a href="/admin/news/{{{ $article["id"] }}}" class="btn btn-info">Edit</a>
							</div>
						</div>	
					</div>
				@endforeach
			
				
			</div>
		</div>
	</div>
@stop