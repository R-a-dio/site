@section("content")

<div class="container main">
	
	<h1>Users List</h1>

	@if (!Auth::user()->isAdmin())

		<h2>You shouldn't be here.</h2>
	@else

		Add a new user with this form:
		{{ Form::open(["url" => "/admin/users", "class" => "form-inline"]) }}
			
			<div class="form-group">
				<input name="username" type="text" placeholder="Username" class="form-control" autocomplete="off">
			</div>
			<div class="form-group">
				<input name="email" type="email" placeholder="Email" class="form-control" autocomplete="off">
			</div>
			<div class="form-group">
				<input name="password" type="password" placeholder="Password" class="form-control" autocomplete="off">
			</div>
			<div class="form-group">
				<select name="privileges" id="user-privs" class="form-control">
					<option value="1">Pending Songs</option>
					<option value="2">DJ Access (Proxy)</option>
					<option value="3">News Posting (Public)</option>
					<option value="4">Admin</option>
				</select>
			</div>

			<button type="submit" class="btn btn-success">Create User</button>
		{{ Form::close() }}

		<hr>

		Existing Users:
		@foreach ($users as $user) 

			<div class="row">
				<div class="col-xs-10">
					{{ Form::open(["url" => "/admin/users/{$user->id}", "class" => "form-inline", "method" => "PUT"]) }}
						<div class="col-xs-11">
							<div class="form-group">
								<label style="min-width: 20px">{{{ $user->id }}}</label>
							</div>
							<div class="form-group">
								<input name="username" type="text" placeholder="Username" class="form-control" autocomplete="off" value="{{{ $user->user }}}">
							</div>
							<div class="form-group">
								<input name="password" type="password" placeholder="Password" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								@if ($user->isDev())
									<label style="padding-left: 15px"> <i class="fa fa-star"></i> Developer</label>
								@else
									<select name="privileges" id="user-privs" class="form-control">
										<option
											value="0"
											@if ($user->privileges == User::NONE)
												selected
											@endif
										>
											Disabled Access
										</option>
										<option
											value="1"
											@if ($user->privileges == User::PENDING)
												selected
											@endif
										>
											Pending Songs
										</option>
										<option
											value="2"
											@if ($user->privileges == User::DJ)
												selected
											@endif
										>
											DJ Access (Proxy)
										</option>
										<option
											value="3"
											@if ($user->privileges == User::NEWS)
												selected
											@endif
										>
											News Posting (Public)
										</option>
										<option
											value="4"
											@if ($user->privileges == User::ADMIN)
												selected
											@endif
										>
											Admin
										</option>
									</select>
								@endif
							</div>
						</div>
						
						<div class="col-xs-1">
							<button type="submit" class="btn btn-info">Edit User</button>
						</div>
						
					{{ Form::close() }}
				</div>

				<div class="col-xs-2">
					{{ Form::open(["url" => "/admin/users/{$user->id}", "method" => "DELETE"]) }}
						<button class="btn btn-danger">Delete User</button>
					{{ Form::close() }}
				</div>
			</div>
			
		@endforeach

	@endif

</div>


@stop