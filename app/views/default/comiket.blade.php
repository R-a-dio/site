@section("content")

	<div class="container main">
		<h1>R/a/dio Winter Comiket Meetup</h1>
		
		<p>If you want to come along for a meetup with R/a/dio in December 2014 for Winter Comiket, enter your details here.</p>
		<p class="text-danger">None of this information is stored in the R/a/dio database (it's on another server) and the only person with access to it is Hiroto.</p>
		<p>If you really care about what this form does, <a href="https://github.com/R-a-dio/site">R/a/dio is open sourced</a>.</p>

		{{ Form::open(["class" => "form-horizontal"]) }}
			<div class="form-group">
				<label class="col-sm-2">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" name="email" placeholder="Email Address" required>
					<p class="help-block">Needed to contact you.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="name" placeholder="Name" required>
					<p class="help-block">Feel free to use a pseudonym here, but actual name is preferred.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Phone Number</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" name="phone" placeholder="Phone Number">
					<p class="help-block">Contact info if you fancy providing it.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Country</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="country" placeholder="Country" required>
					<p class="help-block">So I can get a general idea of whereabouts people are from.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Japanese Proficiency</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="japanese" placeholder="Japanese Proficiency">
					<p class="help-block">Because all the white kids are going to fuck <i>something</i> up in Japan. If in doubt, enter "average /a/ user".</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Age</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" name="age" placeholder="Age"　required>
					<p class="help-block">Self-explanatory. If you enter "12" the form won't actually save. We'll be having drink-ups.</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Gender</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="gender" placeholder="Gender">
					<p class="help-block">
						Stick whatever the heck you like in here, but it helps with booking rooms in hotels if we do a group thing if you put your actual gender.
					</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Password</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="password" placeholder="Password" required>
					<p class="help-block">I'll have you enter this on a form at some point in the future. <span class="text-danger">(passwords are hashed using bcrypt; I have no access to this if you lose it)</span></p>
				</div>
			</div>

			<button type="submit" class="btn btn-success col-sm-10 col-sm-offset-2">Submit Form</button>
		{{ Form::close() }}
	</div>

@stop
