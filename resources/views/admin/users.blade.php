@section("content")

<div class="container main">

	@if (!Auth::user()->isAdmin())

		<h2>You shouldn't be here.</h2>
	@else

		@if ($id)

			<h1>{{{ $users->user }}} <small><a href="/admin/users" class="pull-right">Back</a></small></h1>

			{!! Form::open(["files" => true, "method" => "PUT", "class" => "form-horizontal"]) !!}

				<div class="form-group">
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="username" value="{{{ $users->user }}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" value="{{{ $users->email }}}" placeholder="Email">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Change Password</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Permissions</label>
					<div class="col-sm-10">
						@foreach ($users->getPermissions() as $perm => $hasPerm)
							<label class="checkbox-inline btn btn-default {{ $perm === "dev" ? "disabled" : "" }}">
								<input type="hidden" name="{{{ "p_".$perm }}}" value="false">
								<input type="checkbox" name="{{{ "p_".$perm }}}" value="true" {{ $hasPerm ? "checked" : "" }} >
								{{{ $perm }}}
							</label>
						@endforeach
					</div>
				</div>
				
				<div class="form-group" id="dj">
					<label class="col-sm-2 control-label">DJ Name</label>
					
					<div class="col-sm-10">
						@if ($users->dj)
						<input type="text" class="form-control" value="{{{ $users->dj->djname }}}" name="djname">
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
				<div class="form-group">
					<label class="col-sm-2 control-label">IPv4 Address</label>

					<div class="col-sm-10">
						@if ($users->dj)
						<input type="text" name="ipadr" class="form-control" value="{{{ $users->ip }}}">
						@else
						<input type="text" name="ipadr" class="form-control" value="">
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Visible?</label>
					
					<div class="col-sm-10">
						<label class="btn btn-default">
							<input type="radio" name="visible" value="1" {{($users->dj && $users->dj->visible == 1) ? "checked" : "" }}>Yes
						</label>
						<label class="btn btn-default">
							<input type="radio" name="visible" value="0" {{!($users->dj && $users->dj->visible == 1) ? "checked" : ""}}>No
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Priority</label>

					<div class="col-sm-10">
						@if ($users->dj)
						<input type="number" name="priority" min="1" max="200" class="form-control" value="{{{ $users->dj->priority }}}">
						@else
						<input type="number" name="priority" min="1" max="200" class="form-control" value="200">
						@endif
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">IRC Regex</label>

					<div class="col-sm-10">
						@if ($users->dj)
						<input type="text" name="regex" class="form-control" value="{{{ $users->dj->regex }}}">
						@else
						<input type="text" name="regex" class="form-control" value="">
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<button type="submit" class="btn btn-info">Save</button>
					</div>
				</div>
			{!! Form::close() !!}
		@else
			<h1>Users List</h1>
			Add a new user with this form:
			{!! Form::open(["url" => "/admin/users", "class" => "form-inline"]) !!}
				
				<div class="form-group">
					<input name="username" type="text" placeholder="Username" class="form-control" autocomplete="off">
				</div>
				<div class="form-group">
					<input name="email" type="email" placeholder="Email" class="form-control" autocomplete="off">
				</div>
				<div class="form-group">
					<input name="password" type="password" placeholder="Password" class="form-control" autocomplete="off">
				</div>

				<button type="submit" class="btn btn-success">Create User</button>
			{!! Form::close() !!}

			<hr>

			Existing Users:
			@foreach ($users as $user) 

				{!! Form::open(["url" => "/admin/users/{$user->id}", "class" => "form-horizontal", "method" => "PUT"]) !!}
					<div class="form-group">
						<label class="col-sm-1 control-label">{{{ $user->id }}}</label>
						<div class="col-sm-3">
							<input name="username" type="text" placeholder="Username" class="form-control" autocomplete="off" value="{{{ $user->user }}}" readonly>
						</div>
						<div class="col-sm-3">
							<input name="password" type="password" placeholder="Password" class="form-control" autocomplete="off">
						</div>
						<button type="submit" class="pull-right btn btn-info">Save</button>
						<a href="/admin/users/{{ $user->id }}" class="pull-right btn btn-default">Edit Profile</a>

					</div>
					<div class="form-group">
						<div class="col-sm-11 col-sm-offset-1">
						@foreach ($user->getPermissions() as $perm => $hasPerm)
							<span class="btn btn-xs disabled {{ $hasPerm ? "btn-primary" : "" }}" style="cursor:default;">{{{ $perm }}}</span>
						@endforeach
						</div>
					</div>

				{!! Form::close() !!}
				<hr>
			@endforeach

		@endif
	@endif

</div>


@stop
