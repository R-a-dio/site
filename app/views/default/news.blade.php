@section('content')
	<!-- Main Container
		================ -->
	<div class="container main">

		<div class="content">
			
			@if (!$id)
				<div class="panel-group">
					@foreach ($news as $article)
						@if ($article->private)
							<div class="panel panel-info">
						@else
							<div class="panel panel-default">
						@endif
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="ajax-navigation" href="/news/{{{ $article->id }}}">
										{{{ $article->title }}} <span class="text-muted pull-right">{{{ $article->author->user }}}</span>
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
					@if ($news->private)
						<div class="panel panel-info">
					@else
						<div class="panel panel-default">
					@endif
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="ajax-navigation" href="/news">
								{{{ $news->title }}}
							</a>
							<span class="text-muted pull-right">{{ $news->author->user }}</span>
						</h4>
					</div>
					<div class="panel-body">
						{{ Markdown::render($news->text) }}
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
								@foreach ($comments as $comment)
										<div class="well well-sm parent" id="{{ $comment->id }}">
											<p class="text-muted">
												
												@if (!$comment->user_id)
													Anonymous 
														({{{ 
															(Auth::check() and Auth::user()->isAdmin())
															? $comment->ip : substr(sha1($comment->ip), 0, 4)
														}}})
												@else
													@if ($comment->user->isAdmin())
														<span class="text-danger">
															{{{ $comment->user->user }}} ## Admin
														</span>
													@else
														<span class="text-info">
															{{{ $comment->user->user }}} ## Mod
														</span>
													@endif
												@endif

												#{{{ $comment->id }}}
												<span class="pull-right">({{{ date("Y-m-d H:i:s", strtotime($comment->created_at)) . "UTC" }}})</span>
												@if (Auth::check() and Auth::user()->isAdmin())
													{{ Form::open(["method" => "delete"]) }}
														<button type="submit" name="comment" class="close" value="{{ $comment->id }}">&times;</button>
													{{ Form::close() }}
												@endif
											</p>
											{{ Markdown::render($comment->comment, true, true) }}
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
										Comments use markdown formatting (<a href="#" data-toggle="modal" data-target="#markdown-help">help</a>)
									</p>
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

	<div class="modal fade" id="markdown-help">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Markdown Help</h4>
				</div>
				<div class="modal-body">
					<p>For a complete guide on markdown, see <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">here</a></p>
					<p><i>*italics*</i></p>
					<p><b>**bold**</b></p>
					<p><b><i>***bold italics***</i></b></p>
					<p><strike>~~strikethrough~~</strike></p>
					<p><h1>#header</h1></p>
					<p><code>images: ![description](https://i.imgur.com/fuck.jpg)</code></p>
					<p>HTML is not allowed. Also comments are sanitized.</p>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@stop
