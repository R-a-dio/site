@section('content')

<div class="container main">

	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="well">
				<h2 class="text-center text-success">
					Here be dragons
				</h2>
				@if (Session::has("error"))
					<div class="alert alert-warning alert-dismissable">
						<button class="close" data-dismiss="alert">&times;</button>
						{{{ Session::get("error") }}}
					</div>
				@endif
				{{ Form::open(['url' => 'login', 'class' => 'form-horizontal']) }}
					<div class="form-group">
						<label class="col-md-3 control-label">Username</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="username" placeholder="Username">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Password</label>
						<div class="col-md-9">
							<input type="password" class="form-control" name="password" placeholder="Password">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-9 col-md-offset-3">
							<button class="btn btn-default">Sign In</button>
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
		
	</div>


</div>

@stop
