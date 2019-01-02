@section("content")

<div class="container main">

	@if (!Auth::user()->isAdmin())

		<h2>You shouldn't be here.</h2>
	@else

		@if ($id)

			<h1>{{{ $users->user }}} <small><a href="/admin/users" class="pull-right">Back</a></small></h1>

			{{ Form::open(["files" => true, "method" => "PUT"]) }}

				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control" name="username" value="{{{ $users->user }}}">
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" name="email" value="{{{ $users->email }}}" placeholder="Email">
				</div>
				<div class="form-group">
					<label>Change Password</label>
					<input type="text" class="form-control" name="password" placeholder="Password">
				</div>

				<div class="form-group">
					<label>Privileges</label>
					@if ($users->isDev())
						<select class="form-control" disabled>
							<option selected><i class="fa fa-star"></i> Developer</option>
						</select>
					@else
						<select name="privileges" id="user-privs" class="form-control">
							<option
								value="0"
								@if ($users->privileges == User::NONE)
									selected
								@endif
							>
								Disabled Access
							</option>
							<option
								value="1"
								@if ($users->privileges == User::PENDING)
									selected
								@endif
							>
								Pending Songs
							</option>
							<option
								value="2"
								@if ($users->privileges == User::DJ)
									selected
								@endif
							>
								DJ Access (Proxy)
							</option>
							<option
								value="3"
								@if ($users->privileges == User::NEWS)
									selected
								@endif
							>
								News Posting (Public)
							</option>
							<option
								value="4"
								@if ($users->privileges == User::ADMIN)
									selected
								@endif
							>
								Admin
							</option>
						</select>
					@endif
				</div>
				
				<div class="form-group" id="dj">
					<label>DJ Name</label>
					
					<div>
						@if ($users->dj)
						<input type="text" class="form-control" value="{{{ $users->dj->djname }}}" name="djname">
						@else
						<input type="text" class="form-control" value="" name="djname">
						@endif
					</div>
				</div>
				<div class="form-group">
					<label >DJ Image</label>
					
					<div >
						<input type="file" name="image" id="image">
					</div>
				</div>
				<div class="form-group">
					<label >Visible?</label>
					
					<div >
						@if ($users->dj && $users->dj->visible == 1)
							<label class="btn btn-default">
								<input type="radio" name="visible" value="1" checked="">Yes
							</label>
							<label class="btn btn-default">
								<input type="radio" name="visible" value="0">No
							</label>
						@else
							<label class="btn btn-default">
								<input type="radio" name="visible" value="1">Yes
							</label>
							<label class="btn btn-default">
								<input type="radio" name="visible" value="0" checked="">No
							</label>
						@endif
					</div>
				</div>
				<div class="form-group">
					<label >Priority</label>

					<div >
						@if ($users->dj)
						<input type="number" name="priority" min="1" max="200" class="form-control" value="{{{ $users->dj->priority }}}">
						@else
						<input type="number" name="priority" min="1" max="200" class="form-control" value="200">
						@endif
					</div>
				</div>
				<div class="form-group">
					<label >IPv4 Address</label>

					<div >
						@if ($users->dj)
						<input type="text" name="ipadr" class="form-control" value="{{{ $users->ip }}}">
						@else
						<input type="text" name="ipadr" class="form-control" value="200">
						@endif
					</div>
				</div>

				<button type="submit" class="btn btn-info">Edit User</button>
			{{ Form::close() }}
		@else
			<h1>Users List</h1>
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

				{{ Form::open(["url" => "/admin/users/{$user->id}", "class" => "form-inline", "method" => "PUT"]) }}
					<div class="form-group">
						<label style="min-width: 20px">{{{ $user->id }}}</label>
					</div>
					<div class="form-group">
						<input name="username" type="text" placeholder="Username" class="form-control" autocomplete="off" value="{{{ $user->user }}}" disabled>
					</div>
					<div class="form-group">
						<input name="password" type="password" placeholder="Password" class="form-control" autocomplete="off">
					</div>
					<div class="form-group">
						@if ($user->isDev())
							<select class="form-control" disabled>
								<option checked><i class="fa fa-star"></i> Developer</option>
							</select>
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
					
				<button type="submit" class="pull-right btn btn-info">Edit User</button>
				<a href="/admin/users/{{ $user->id }}" class="pull-right btn btn-default">Profile</a>
				{{ Form::close() }}
				<hr>
			@endforeach

		@endif
	@endif

</div>


@stop
