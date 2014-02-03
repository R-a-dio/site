@section("content")

	<div class="container main">
		<h1>Your Profile</h1>

		{{ Form::open(["method" => "PUT", "class" => "form-horizontal"]) }}
		
			<div class="form-group">
				<label class="col-sm-2 control-label">Username</label>

				<div class="col-sm-10">
					<input type="text" class="form-control" value="{{{ Auth::user()->user }}}" disabled>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" value="{{{ Auth::user()->email }}}" name="email">
				</div>
			</div>

			<div class="form-group" id="password">
				<label class="col-sm-2 control-label">Change Password</label>

				<div class="col-sm-10">
					<input type="password" class="form-control" placeholder="Current Password" name="check">
					<br>
					<input type="password" class="form-control" placeholder="New Password" name="password">
					<br>
					<input type="password" class="form-control" placeholder="Repeat Password" name="confirm">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<button type="submit" class="btn btn-success">Update Profile</button>
				</div>
			</div>

		{{ Form::close() }}
	</div>

@stop
