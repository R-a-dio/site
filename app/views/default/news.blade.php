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
											{{{ $article["header"] }}}
										</a>
									</h4>
								</div>
							</div>
						@endforeach
					</div>
				@else
					<div class="panel-group">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="ajax-navigation" href="/news">
										{{{ $news["header"] }}}
									</a>
								</h4>
							</div>
						</div>
					</div>

				@endif

			</div>

		</div>
@stop
