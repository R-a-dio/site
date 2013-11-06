@section('content')

<div class="container main">

	<div class="container">
		<div class="col-md-6">
			<div class="well">
				<h2 class="text-center text-success">
					Log In With
				</h2>
				{{ Form::open(['url' => 'login']) }}
					<div class="form-group">
						<a href="" class="btn btn-google"></a>
					</div>
				{{ Form::close() }}
			</div>
		</div>
		<div class="col-md-6">
			<div class="well">
				<h2 class="text-center text-warning">
					Register
				</h2>
 
			</div>
		</div>
	</div>


</div>

@stop