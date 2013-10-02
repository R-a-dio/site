@section('content')
	<div class="container main">
		<div class="col-md-4">
			<div class="well">
				<div class="well errors">
					<h3>15 Error Messages.</h3>
					<p>The last one was <a href="#">15 mins ago</a></p>
					<p class="text-center"><a href="#" class="btn btn-info">Reset Error Counter</a></p>
				</div>
				<div class="well pending">
					<h3>150 Pending Songs.</h3>
					<p>The last accepted song was <a href="#">5 months ago</a></p>
					<p class="text-center"><a href="#" class="btn btn-danger">Bloody Accept Something</a>

				</div>
				<div class="well">
					<h3>42 Notifications</h3>
					<p>Some serious shit right there. You should probably try viewing these once in a while.</p>
					<p class="text-center"><a href="#" class="btn btn-success">View Notifications</a></p>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel-group" id="accordion">

				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-news-116">
						  Admin-only news.
						</a>
					  </h4>
					</div>
					<div id="collapse-news-116" class="panel-collapse collapse in">
						<div class="panel-body">
							<span class="date">2013-04-08 01:44:05</span>
							<p>Now you listen here, shrimpy, this is the news.</p>
						</div>
					</div>	
				</div>
			
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-news-115">
						  Another one.
						</a>
					  </h4>
					</div>
					<div id="collapse-news-115" class="panel-collapse collapse">
						<div class="panel-body">
							<span class="date">2013-04-08 01:44:05</span>
							<p>Now you listen here, shrimpy, this is the news.</p>
						</div>
					</div>	
				</div>

			</div>			
		</div>
	</div>
@stop