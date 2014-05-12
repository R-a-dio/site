@section("content")

	<div class="container main">
		<h1>Your Profile</h1>

		{{ Form::open(["files" => true, "method" => "PUT", "class" => "form-horizontal"]) }}
		
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
			@if (Auth::user()->isAdmin() || Auth::user()->dj)
				<div class="form-group" id="dj">
					<label class="col-sm-2 control-label">DJ Name</label>
					
					<div class="col-sm-10">
						@if (Auth::user()->dj)
						<input type="text" class="form-control" value="{{{ Auth::user()->dj->djname }}}" name="djname">
						@else
						<input type="text" class="form-control" value="" name="djname">
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">DJ Image</label>
					
					<div class="col-sm-10">
						<input type="file" name="image" id="image">
					</div>
				</div>
				@if (Auth::user()->isAdmin())
					<div class="form-group">
						<label class="col-sm-2 control-label">Visible?</label>
						
						<div class="col-sm-10">
							@if (Auth::user()->dj && Auth::user()->dj->visible == 1)
								<label class="btn btn-default active">
									<input type="radio" name="visible" value="1" checked>Yes
								</label>
								<label class="btn btn-default">
									<input type="radio" name="visible" value="0" >No
								</label>
							@else
								<label class="btn btn-default">
									<input type="radio" name="visible" value="1" >Yes
								</label>
								<label class="btn btn-default active">
									<input type="radio" name="visible" value="0" checked>No
								</label>
							@endif
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Priority</label>

						<div class="col-sm-10">
							@if (Auth::user()->dj)
							<input type="number" name="priority" min="1" max="200" class="form-control" value="{{{ Auth::user()->dj->priority }}}">
							@else
							<input type="number" name="priority" min="1" max="200" class="form-control" value="200">
							@endif
						</div>
					</div>
				@endif
			@endif
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<button type="submit" class="btn btn-success">Update Profile</button>
				</div>
			</div>

		{{ Form::close() }}
	</div>

@stop
