@section('content')
		<!-- Main Container
			================ -->
		<div class="container main">

			<div class="content">
				
				@if (!$id)
					<div class="panel-group">
						@foreach ($news as $article)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="ajax-navigation" href="/news/{{{ $article["id"] }}}">
											{{{ $article["title"] }}}
										</a>
									</h4>
								</div>
							</div>
						@endforeach

						<div class="text-center">
							{{ $news->links() }}
						</div>
					</div>
				@else
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="ajax-navigation" href="/news">
									{{{ $news["title"] }}}
								</a>
								<small class="pull-right">{{ $news->author->user }}</small>
							</h4>
						</div>
						<div class="panel-body">
							{{ Markdown::render($news["text"]) }}
						</div>
					</div>

					<div class="row">
						<div class="col-md-8">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										Comments
									</h4>
								</div>
								<div class="panel-body">
									@foreach ($news->comments as $comment)
										<div class="row comments">
											<div class="well parent">
												<p class="text-muted">{{{ $comment->author() }}}</p>
												<p>{{{ $comment->comment }}}</p>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										Comment Form
									</h4>
								</div>
								<div class="panel-body">
									{{ Form::open() }}
										<div class="form-group">
											<textarea data-id="{{{ $news["id"] }}}" name="comment" rows="4" class="comment-input form-control" placeholder="Enter a comment..."></textarea>
										</div>

										@if (Auth::check())
											<p class="help-block">Logged in (as {{{ Auth::user()->user }}}), no need for a captcha~</p>
										@else
											<p class="help-block">There'll be a captcha here eventually.</p>
										@endif
										<p class="help-block">
											<span id="char-count-{{{ $news["id"] }}}">500</span> characters remaining.
										</p>
										<button type="submit" class="btn btn-primary">Post Comment</button>
									{{ Form::close() }}
								</div>
							</div>
						</div>
					</div>
					
				@endif

			</div>

		</div>
@stop
