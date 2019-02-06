<div class="row news-row">
			
	@foreach ($news->slice(0, $count) as $article)
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="/news/{{ $article->id }}" class="ajax-navigation">
						<h3 class="panel-title">{{{ $article->title }}} <span class="text-muted pull-right">~{{{ $article->author->user }}}</span></h3>
					</a>
				</div>
				<div class="panel-body">
					<small class="text-muted">{{{ $article->created_at->format("D, d M y H:i:s T") }}}</small>
					{!! Markdown::render($article->header) !!}
				</div>
			</div>
		</div>
	@endforeach

</div><!-- /.row -->
