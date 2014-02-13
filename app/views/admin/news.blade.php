@section("content")

	<div class="container">

		@if ($id)

			@if ($news["private"])
				<div class="panel panel-info">
			@else
				<div class="panel panel-default">
			@endif
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="/admin/news/{{{ $news->id }}}">
							{{{ $news->title }}} <span class="pull-right text-muted">{{{ $news->author->user }}}</span>
						</a>
					</h4>
				</div>
				<div class="panel-body">
					<span class="date text-muted">
						{{{ $news->created_at }}}
						@if ($news->updated_at)
							(updated: {{{ $news->updated_at }}})
						@endif
					</span>
					<hr>
					{{ Form::open(["method" => "PUT"]) }}
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" value="{{{ $news->title }}}" class="form-control">
						</div>
						<div class="form-group">
							<label>Header</label>
							<textarea name="header" id="" cols="30" rows="10" class="form-control">{{{ $news->header }}}</textarea>
						</div>
						<div class="form-group">
							<label>Body</label>
							<textarea name="text" id="" cols="30" rows="10" class="form-control">{{{ $news->text }}}</textarea>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="private" value="0"
								@if (!$news->private)
									checked
								@endif
								>
								Public
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="private" value="1"
								@if ($news->private)
									checked
								@endif
								>
								Private
							</label>
						</div>
						<button type="submit" class="btn btn-info">Update Post</button>
					{{ Form::close() }}
					<hr>
					@if (Auth::user()->isAdmin())
						{{ Form::open(["method" => "DELETE"]) }}

							<button type="submit" class="btn btn-danger">Delete Post</button> &#8212; Danger Zone&trade; (Don't worry, nothing is deleted; it's soft-deleted and can be recovered)

						{{ Form::close() }}
					@endif
				</div>
			</div>

		@else

			<div class="panel-group" id="accordion">

				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-new-post">
								New Post <span class="pull-right text-muted">Logged in as {{{ Auth::user()->user }}}</span>
							</a>
						</h4>
					</div>
					<div id="collapse-new-post" class="panel-collapse collapse">
						<div class="panel-body">
							{{ Form::open(["method" => "POST"]) }}
								<div class="form-group">
									<label>Title</label>
									<input type="text" name="title" placeholder="Title" class="form-control">
								</div>
								<div class="form-group">
									<label>Header</label>
									<textarea name="header" id="" cols="30" rows="10" class="form-control" placeholder="Header"></textarea>
								</div>
								<div class="form-group">
									<label>Body</label>
									<textarea name="text" id="" cols="30" rows="10" class="form-control" placeholder="Body"></textarea>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="private" value="0" checked>
										Public
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="private" value="1">
										Private
									</label>
								</div>
								<button type="submit" class="btn btn-info">Create Post</button>
							{{ Form::close() }}
						</div>
					</div>	
				</div>
				
			</div>

			<hr>

			@foreach ($news as $article)
				@if ($article->private)
					<div class="panel panel-info">
				@else
					<div class="panel panel-default">
				@endif
					<div class="panel-heading">
						<h4 class="panel-title">
							<a href="/admin/news/{{{ $article->id }}}">
								{{{ $article->title }}} # {{ $article->id }} <span class="pull-right text-muted">{{{ $article->author->user }}}</span>
							</a>
						</h4>
					</div>
				</div>
			@endforeach
		@endif
	</div>

@stop
