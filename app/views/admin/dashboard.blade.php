@section('content')
	<div class="container main">
		<div class="col-md-4">
			<div class="well">
				<div class="well errors">
					<h3>0 Error Messages.</h3>
					<p>The last one was <a href="#">x mins ago</a></p>
					<p class="text-center"><a href="/admin/errors" class="btn btn-info">Reset Error Counter</a></p>
				</div>
				<div class="well pending">
					<h3>0 Pending Songs.</h3>
					<p>The last accepted song was <a href="#">x mins ago</a></p>
					<p class="text-center"><a href="/admin/pending" class="btn btn-danger">Bloody Accept Something</a>

				</div>
				<div class="well">
					<h3>{{{ $notifications->count() }}} Notifications</h3>
					<p>These are mostly for admins, but occasionally there's a global announce.</p>
					<p class="text-center"><a href="/admin/notifications" class="btn btn-success">View Notifications</a></p>
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