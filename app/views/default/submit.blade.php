@section("content")

	<div id="submitpage" class="container main content">
		<h1>{{{ trans("submit.title") }}}</h1>
		@include("partials.submission-guidelines")
		<div class="row">
			<div class="col-xs-12">
				@if ($cooldown)
					<div class="alert alert-danger text-center" id="cooldown">
				@else
					<div class="alert alert-success text-center" id="cooldown">
				@endif
					{{ $message }}
				</div>
			</div>
			<div class="col-md-6">
				<p>
					<strong>{{{ trans("submit.guidelines.upload.title") }}}</strong>
					<ul>
						<li>{{{ trans("submit.guidelines.upload.search") }}}</li>
						<li>Low quality uploads are likely to be declined if it's obvious better quality versions are available</li>
						<li>Anything below 192kbps is rejected. Do not upload YouTube rips.</li>
						<li>{{{ trans("submit.guidelines.upload.source") }}}</li>
						<li><a style="cursor: pointer;" data-toggle="modal" data-target="#submission-guidelines">Why did my submission get declined?</a></li>
					</ul>
				</p>
				<p>
					<strong>{{{ trans("submit.guidelines.tagging.title") }}}</strong>
					<ul>
						<li>{{{ trans("submit.guidelines.tagging.required") }}}</li>
						<li>{{{ trans("submit.guidelines.tagging.runes") }}}</li>
						<li>{{{ trans("submit.guidelines.tagging.cv") }}}</li>
						<li>If you can remember, please include where you downloaded the file from</li>
						<li><a href="https://static.r-a-d.io/exci/good-comment.png">An example of a good comment</a></li>
					</ul>
				</p>
			</div>
			<div class="col-md-6">
				{{ Form::open(["files" => true, "id" => "submit"]) }}

					<div class="form-group upload-form" id="file-input">
						<input type="file" name="song" id="song">
						<span class="form-control-feedback">
							<i class="fa fa-check" id="feedback-success" style="display: none"></i>
							<i class="fa fa-times" id="feedback-error" style="display: none"></i>
						</span>
						
						<p class="help-block">
							{{{ trans("submit.upload.desc") }}}
						</p>
					</div>

					<div class="form-group" id="upload-progress" style="display: none">
						<div class="progress progress-striped active">
							<div id="file-progress-bar" class="progress-bar progress-bar-success"  role="progressbar" style="width: 0%"></div>
						</div>
						<p class="help-block" id="uploading">Uploading <span id="filename">file</span>... <span id="file-progress">0</span>%</p>
						<p class="help-block" id="uploaded" style="display: none">
							Uploaded <span id="filename">file</span>!
						</p>
						<p class="help-block" id="errored" style="display: none">Your Browser does not support HTML5 file uploading.</p>
					</div>

					<div class="form-group upload-form">
						<input type="text" class="form-control" name="comment" id="comment" placeholder="{{{ trans("submit.comment.label") }}}">
						<p class="help-block">
							{{{ trans("submit.comment.desc") }}}
						</p>
					</div>
					
					<!--email_off-->
					<div class="form-group upload-form">
						<label class="control-label">Replacement</label>
						<select name="replacement" class="form-control">
							<option value="0">No replacement</option>
							@foreach ($replacements as $r)
							<option value="{{ $r->id }}">{{{ $r->artist === "" ? $r->title : $r->artist . " - " . $r->title }}}</option>
							@endforeach
						</select>
						<p class="help-block">
							Sometimes, songs in the database aren't up to snuff. If you have a good copy of a track listed here, select the track in the list and upload it!
						</p>
					</div>
					<!--/email_off-->

					<div class="form-group upload-form" id="daypass">
						<input type="text" class="form-control" name="daypass" placeholder="{{{ trans("submit.daypass.label") }}}">
						<ul class="help-block" style="list-style-type:none;margin-left:-40px;">
								<!--<li>{{{ trans("submit.daypass.desc") }}}</li>-->
                                                                <li>Enter the daypass and you can have unlimited uploads until midnight, UTC. <a href="https://static.r-a-d.io/exci/daypass-guide.webm">Ask exci in IRC for it</a>. USE WITH DISCRETION.</li>
                                                                <li>Uploading full soundtracks or albums without asking for a daypass will probably end in everything being declined.</li>

						</ul>
						<!--<p>
							Uploading full soundtracks without asking for one will probably end in everything being declined.
						</p>-->

					</div>

					<div class="form-group upload-form">
						<button type="submit" id="submit-button" class="btn btn-default ajax-upload">
							{{{ trans("submit.upload.label") }}}
						</button>
					</div>

				{{ Form::close() }}
			</div>
		</div>

		<div class="row">
			<br>
			<div id="pendingsongsamount" class="alert text-center">
				There are currently {{{ $pending_amount }}} pending tracks awaiting approval.
			</div>
		</div>

		<div class="row">
			<hr>
			<div class="col-md-6">
				<h2 class="text-success text-center">{{{ trans("submit.accepts") }}}</h2>
				@if ($ip_accs >= 0)
				<div class="row">
					<div class="alert text-center">
						{{{ $pending_accepted_total }}} accepted submissions.<br>
						{{{ $pending_accepted_2weeks }}} accepted in the last 2 weeks.<br>
						{{{ $ip_accs }}} accepted submissions from (You).
					</div>
				</div>
				@endif
				<br>
				@foreach ($accepts as $accept)
					<div class="row">
						<div class="col-md-12">
							@if ($accept["accepted"] == 2)
								<span class="text-success">
									{{{ $accept["meta"] }}}
								</span>
							@else
								{{{ $accept["meta"] }}}
							@endif
							
						</div>
					</div>
					<hr>
				@endforeach
			</div>
			<div class="col-md-6">
				<h2 class="text-danger text-center">{{{ trans("submit.declines") }}}</h2>
				@if ($ip_decs >= 0)
				<div class="row">
					<div class="alert text-center">
						{{{ $pending_declined_total }}} declined submissions.<br>
						{{{ $pending_declined_2weeks }}} declined in the last 2 weeks.<br>
						{{{ $ip_decs }}} declined submissions from (You).
					</div>
				</div>
				@endif
				<br>
				@foreach ($declines as $decline)
					<div class="row">
						<div class="col-md-8" style="overflow-x: hidden">{{{ $decline["meta"] }}}</div>
						<div class="col-md-4 text-danger">{{{ $decline["reason"] }}}</div>
					</div>
					<hr>
				@endforeach
			</div>

		</div>
		
		<div class="modal fade" id="upload">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="upload-title">Uploading File</h4>
					</div>
					<div class="modal-body">
						
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div>
	<script>

		function showUploading() {
			$("#uploading").show();
			$("#uploaded").hide();
			$("#errored").hide();
			$("#feedback-success").show();
			$("#feedback-error").hide();
			$("#file-input").addClass("has-success").addClass("has-feedback").removeClass("has-error");
			$("#file-progress-bar").addClass("progress-bar-success").removeClass("progress-bar-danger");
		}

		function showUploaded() {
			$("#uploaded").show();
			$("#uploading").hide();
			$("#errored").hide();
			$("#feedback-success").show();
			$("#feedback-error").hide();
			$("#file-input").addClass("has-success").addClass("has-feedback").removeClass("has-error");
			$("#file-progress-bar").addClass("progress-bar-success").removeClass("progress-bar-danger");
			$(".upload-form").show();
			$("#daypass").hide();
		}
		function showErrored() {
			$("#uploading").hide();
			$("#uploaded").hide();
			$("#errored").show();
			$("#feedback-success").hide();
			$("#feedback-error").show();
			$("#file-input").addClass("has-error").addClass("has-feedback").removeClass("has-success");
			$("#file-progress-bar").removeClass("progress-bar-success").addClass("progress-bar-danger");
			$(".upload-form").show();
			$("#daypass").hide();
		}

		function checkCooldown() {
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "/api/user-cooldown", true);
			xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

			xhr.onload = function (e) {
				if (xhr.status >= 200 && xhr.status < 400) {
					var data = JSON.parse(xhr.responseText);

					if (data.message) {

						var delay = data.delay,
							now = data.now,
							cooldown = data.cooldown,
							message = data.message;

						console.log(data);

						if (data.cooldown == false || (now - cooldown > delay)) {
							$("#cooldown").removeClass("alert-danger").addClass("alert-success");
							$("#cooldown").html(message);
						} else {
							$("#cooldown").removeClass("alert-success").addClass("alert-danger");
							$("#cooldown").html(message);
						}

					} else {
						console.log(data);
						$("#cooldown").removeClass("alert-success").addClass("alert-danger");
						$("#cooldown").text("An error occurred fetching your cooldown status.");
					}
					


				} else {
					console.log(xhr);
					$("#errored").text("An unknown error occurred");
				}
			};

			xhr.send();
		}

		// delegate event to the click button
		$("#submit").submit(function (e) {
			e.preventDefault();
			$("#submit-button").click();
		});

		$(':file').change(function(){
			var file = this.files[0],
				name = file.name,
				size = (file.size / 1048576).toFixed(1),
				type = file.type,
				error;

			$("#filename").text(name + " (" + size + "MB)");

			if (size > 20.0) {
				error = true;
			}

			if (!file) {
				error = true;
			}

			if (error) {
				showErrored();
			} else {
				showUploading();
			}

			$("#file-progress-bar").css("width", "0%");


			
		});

		$("#submit-button").click(function (e) {

			var $form = $("#submit"),
				xhr = new XMLHttpRequest();
			
			if ($form.find("input[name=comment]")[0].value.trim() === "") {
				$("#errored").text("You must enter a comment! Please give source!");
				$("#upload-progress").show();
				showErrored();
				e.preventDefault();
				return;
			}
			
			if (!$form.find("input[name=song]")[0].files[0]) {
				$("#errored").text("No file was selected.");
				$("#upload-progress").show();
				showErrored();
				e.preventDefault();
				return;
			} else {
				showUploading();
			}
			
			$(".upload-form").hide();
			
			if (typeof FormData !== "undefined" && xhr.upload) {
				var $data = new FormData();
				// form data
				$data.append("song", $form.find("input[name=song]")[0].files[0]);
				$data.append("_token", $form.find("input[name=_token]").val());
				$data.append("daypass", $form.find("input[name=daypass]").val());
				$data.append("comment", $form.find("input[name=comment]").val());
				$data.append("replacement", $form.find("select[name=replacement]").val());

				xhr.open("POST", "/submit", true);
				xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
				$("#upload-progress").show();
				xhr.onload = function (e) {
					
					if (xhr.status >= 200 && xhr.status < 400) {
						console.log(xhr.responseText);
						var data = JSON.parse(xhr.responseText);

						if (data.value.error) {
							showErrored();

							if (data.value.error instanceof Array) {
								var error = data.value.error.join("<br>");
								$("#errored").html(error);
							} else {
								var error = data.value.error;
								$("#errored").text(error);
							}

						} else if (data.value.success) {
							$("#uploaded").text(data.value.success).show();
							showUploaded();

							checkCooldown();
						} else {
							$("#errored").text("An unknown error occurred.");
							console.log(data);
							
							showErrored();
						}
						


					} else {
						$("#errored").text("An unknown error occurred.");
						showErrored();
					}

					$("#file-progress-bar").css("width", "100%");
					
				};

				xhr.upload.addEventListener("progress", function(progress) {
					var percent = (progress.loaded / progress.total) * 100;
					console.log(percent);
					showUploading();
					$("#file-progress-bar").css("width", percent + "%");
					$("#file-progress").text(percent.toFixed(0));
				});

				xhr.onerror = function (e) {
					console.log(xhr.responseText);
				};

				xhr.send($data);

				// prevent submission normally
				return false;
			} else {
				// oops, submit normally
				return true;
			}

			
		});
	</script>
@stop
