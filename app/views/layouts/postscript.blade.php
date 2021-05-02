<!-- Bootstrap core JavaScript
	================================================== -->
<!-- script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script -->
<script src="/js/bootstrap-3.1.0.min.js"></script>
<script src="/js/jquery.timeago.js"></script>
<!-- History.js -->
<script src="/js/jquery.history.js"></script>
<script src="/js/konami.js"></script>

<script>
	$(function() {
		$.timeago.settings.autoDisposal = true;
		$.timeago.settings.allowFuture = true;
		$.timeago.settings.strings.minutes = "%d mins";
		$.timeago.settings.strings.minute = "less than a min";
		$.timeago.settings.strings.seconds = "less than a min";
		$.timeago.settings.strings.suffixFromNow = null;
		$.timeago.settings.strings.prefixFromNow = "in";
		var konami = new Konami(function() {
			$("#daypass").show();
		});
		
		function supports_html5_storage() {
			try {
				return 'localStorage' in window && window['localStorage'] !== null;
			} catch (e) {
				return false;
			}
		}

		$.fn.serializeObject = function() {
			var o = {};
			var a = this.serializeArray();
			$.each(a, function() {
				if (o[this.name] !== undefined) {
					if (!o[this.name].push) {
						o[this.name] = [o[this.name]];
					}
					o[this.name].push(this.value || '');
				} else {
					o[this.name] = this.value || '';
				}
			});
			return o;
		};
		window.player_source_set = false;
		function handlers() {
			$("time.timeago").timeago();

			// Ajaxify
			$('a.ajax-navigation, ul.pagination>li>a').click(function(event) {

				// Continue as normal for cmd clicks etc
				if (event.which == 2 || event.metaKey) { return true; }

				event.preventDefault();

				History.pushState(null, $(this).text(), $(this).attr("href"));
				
				return false;
			});

			$('form.ajax-search').submit(function(event) {

				// Continue as normal for cmd clicks etc
				if (event.which == 2 || event.metaKey) { return true; }

				event.preventDefault();

				var arr = $(this).serializeObject();
				
				History.pushState(null, $(this).text(), $(this).attr("action") + "/" + arr.q);
				
				return false;
			});

			$("textarea.comment-input").keyup(function() {
				var $object = $(this);
				var id = $object.attr("data-id");
				var value = $object.val();
				$("#char-count-" + id).text(500 - value.length);
			});

			$(".request-button").click(function (e) {
				e.preventDefault();
				var id = $(this).val(),
					token = $(this).closest("form").find("input[name='_token']").val();
				$.ajax({
					url: "/request/" + id,
					type: "POST",
					data: { _token: token },
					dataType: "json",
					success: function (data) {
						var result;

						if (data.error) {
							result = data.error;
						} else if (data.success) {
							result = data.success;
						} else {
							console.log(data);
						}

						$("#requests .modal-body").text(result);
						$("#requests").modal();
						
					}
				});
				return false;
			});

		}
		handlers();

		
		/**
		 * Replaces <time>'s content so it complies with the user's time zone
		 * in /queue and /last-played
		 */
		function replaceTimeZones($section) {
			if ($section.attr('data-uri') == '/queue' || $section.attr('data-uri') == '/last-played') {
				var today = new Date();
				today.setHours(0,0,0,0);

				$section.find('time').each(function(){
					var d = new Date(this.getAttribute('datetime'));
					this.firstChild.nodeValue = d < today ? d.toLocaleString('sv') : d.toLocaleTimeString('sv');
				});
			}
		}
		replaceTimeZones($('.radio-content-panel.current'));


		$(window).on("statechange", function(event) {
			var state = History.getState();
			var root = History.getRootUrl();

			var uri = state.url.replace(root, "/");

			

			// handle li.active
			var active = uri.split("/")[1];

			$(".navbar .active").removeClass("active");
			var $active = $(".navbar a[href='/" + active + "']");

			if ($active.hasClass("drop")) {
				$active = $active.closest("li.dropdown");
			} else {
				$active = $active.closest("li");
			}

			$(".dropdown.open .dropdown-toggle").dropdown("toggle");
			
			$active.addClass("active");

			var $main = $("[data-uri='/']");
			var $irc = $("[data-uri='/irc']");

			if (uri == "/") {

				if (!$main.length) {
					$.ajax({
						url: "/",
						type: "GET",
						dataType: "html",
						success: function(data) {
							if (data) {
								var $section = $(data);
								var $current = $("#radio-container > .current");

								if ($current.attr("data-uri") == "/irc") {
									$current.removeClass("current").hide();
								} else {
									$current.remove();
								}

								$section.appendTo($("#radio-container")).addClass("current").show();

								handlers();

							}
						}
					});
				} else {
					var $current = $("#radio-container > .current");

					 if ($current.attr("data-uri") == "/irc") {
					 	// hide IRC
						$current.removeClass("current").hide();
					} else {
						// trash it
						$current.remove();
					}

					$main.addClass("current").show();

				}
			} else if (uri == "/irc") {
				if (!$irc.length) {
					$.ajax({
						url: "/irc",
						type: "GET",
						dataType: "html",
						success: function(data) {
							if (data) {
								var $section = $(data);
								var $current = $("#radio-container > .current");

								if ($current.attr("data-uri") == "/") {
									$current.removeClass("current").hide();
								} else {
									$current.remove();
								}

								$section.appendTo($("#radio-container")).addClass("current").show();

								handlers();

							}
						}
					});
				} else {
					var $current = $("#radio-container > .current");

					if ($current.attr("data-uri") == "/") {
						// hide main
						$main.removeClass("current").hide();
					} else {
						// trash it
						$current.remove();
					}

					$irc.addClass("current").show();
				}

			} else {
				// we need to fetch it and append it

				$.ajax({
					url: uri,
					type: "GET",
					dataType: "html",
					success: function(data) {
						if (data) {
							var $section = $(data);

							var $current = $("#radio-container > .current");
							if ($current.attr("data-uri") == "/" || $current.attr("data-uri") == "/irc") {
								$current.removeClass("current").hide();
							} else {
								$current.remove();
							}
							
							replaceTimeZones($section);

							$section.appendTo($("#radio-container")).addClass("current").show();

							handlers();

						}
					}
				});
			}

		});

		



		///////////////////////////////////////////////////////////////////////
		// HERE BE DRAGONS
		// MOVE TO MAIN.JS WHEN DONE
		///////////////////////////////////////////////////////////////////////

		window.radio = {
			counter: 0.0,
			sync_seconds: 0,
			update_progress: 0.0,
			update_progress_inc: 0.0,
			update_old_progress: 0.0,
			current_pos: 0,
			current_len: 0,
			afk: "init",
			thread: "init",
			djimg: 0
		};

		String.prototype.format = function() {
			var args = arguments;
			return this.replace(/{(\d+)}/g, function(match, number) { 
				return typeof args[number] != 'undefined'
				? args[number]
				: match
				;
			});
		};

		function setDjImage(image) {
			if(radio.djimg != image) {
				$("#dj-image").attr("src", "/api/dj-image/" + image);
				radio.djimg = image;
			}
		}

		function setDJ(dj) {
			$("#dj-name").text(dj.djname);
			setDjImage(dj.djimage);

			var url = '/assets/logo_image_small.png';
			if (dj.djname.toLowerCase().indexOf('sauce') !== -1)
				url = '/assets/logo_image_small_sauce.png';
			else if (new Date().getMonth() == 11)
				url = '/assets/logo_image_small_christmas.png';

			var img = document.querySelector('img[alt="R/a/dio"]');
			if (img.getAttribute('src') !== url && img.getAttribute('src').startsWith('/assets/logo_image'))
				img.setAttribute('src', url);
		}

		function nowPlaying(np) {
			$("#np").text(np);
		}

		function setListeners(listeners) {
			$("#listeners").text(listeners);
		}

		function updateLastPlayed(lp) {
			var $lp = $("#lastplayed .last-played");
			var count = 0;
			$lp.each(function() {
				var lastplayed = lp[count];
				$(this).find(".lp-time").html(lastplayed.time);
				$(this).find(".lp-meta").text(lastplayed.meta);
				count++;
			});
		}

		function updateQueue(q) {
			var $q = $("#queue .queue");
			var count = 0;
			$q.each(function() {
				var queue = q[count];
				$(this).find(".q-time").html(queue.time);
				$(this).find(".q-meta").text(queue.meta);

				if (queue.type > 0) {
					$(this).addClass("list-group-item-info");
				} else {
					$(this).removeClass("list-group-item-info");
				}

				count++;
			});
		}

		function updateThread(isafk, thread) {
			radio.afk = isafk;
			// Swap the queue and the thread box if needed.
			if (radio.afk && $("#dj-mode").is(":visible")) {
				$("#queue").show();
				$("#dj-mode").hide();
			} else if (!(radio.afk || $("#dj-mode").is(":visible"))) {
				$("#queue").hide();
				$("#dj-mode").show();
			}
			// Set thread if necessary.
			if (radio.thread !== thread) {
				if (thread.toLowerCase() === "none") {
					// no thread
					$("#dj-mode").children()
						.replaceWith($('<h2 class="text-center">There is currently no thread up.</h2>'));
				} else {
					// thread
					t = thread.replace("\"", "\\\""); // ugh im so good
					$("#dj-mode").children()
						.replaceWith($('<h1 class="text-center thread"><a href="' + t + '">Thread up!</a></h1>'));
				}
			}
			radio.thread = thread;
		}

		function updatePeriodic() {
			$.ajax({
				method: 'get',
				url: "/api",
				dataType: 'json',
				success: function (resp) {
					nowPlaying(resp.main.np);
					setListeners(resp.main.listeners);
					updateThread(resp.main.isafkstream, resp.main.thread);
					setDJ(resp.main.dj);
					updateLastPlayed(resp.main.lp);
					updateQueue(resp.main.queue);
					parseProgress(resp.main.start_time, resp.main.end_time, resp.main.current);
					$("time.timeago").timeago();
				}
			});
		}

		function parseProgress(start, end, cur) {
			if (end != 0) {
				radio.cur_time = Math.round(new Date().getTime() / 1000.0);
				radio.sync_seconds = radio.cur_time - cur;
				end += radio.sync_seconds;
				start += radio.sync_seconds;
				radio.temp_update_progress = 0;
				radio.duration = end - start;
				radio.position = radio.cur_time - start;
				radio.update_progress = 100 / radio.duration * radio.position;
				radio.update_progress_inc = 100 / radio.duration;
				radio.current_pos = radio.position;
				radio.current_len = radio.duration;
			}
			else {
				radio.update_progress = false;
			}
		}


		function secondsToReadable(seconds) {
			var hours = Math.floor(seconds / 3600);
			var mins = Math.floor((seconds % 3600) / 60);
			var secs = Math.floor((seconds % 3600) % 60);
			return (
				hours > 0 ? +
				(hours < 10 ? '0' : '') +
				hours + ':' : '') +
				(mins < 10 ? '0' :'') +
				mins + ':' +
				(secs < 10 ? '0' : '') + secs;
		}

		function applyProgress() {
			if (radio.update_progress) {
				if ((radio.update_progress < radio.update_old_progress) || (radio.update_old_progress == false)) {
					radio.update_progress += radio.update_progress_inc;
					$("#progress .progress-bar").removeClass("progress-bar-danger");
					$("#progress .progress-bar").css({width: "{0}%".format(radio.update_progress)});
				}
				else {
					radio.update_progress += radio.update_progress_inc;
					$("#progress .progress-bar").removeClass("progress-bar-danger");
					$("#progress .progress-bar").css({width: "{0}%".format(radio.update_progress)});
				}
				// Fill the duration counter
				$("#progress-current").text(secondsToReadable(radio.current_pos));
				$("#progress-length").text(secondsToReadable(radio.current_len));
			}
			else {
				$("#progress .progress-bar").addClass("progress-bar-danger");
				$("#progress .progress-bar").css({width: "100%"})
				// Empty the duration counter
				$("#progress-current").empty();
				$("#progress-length").empty();
			}
			radio.update_old_progress = radio.update_progress;
		}

		function periodic() {
			radio.counter += 1;
			radio.current_pos += 1;
			applyProgress();
			if (radio.counter >= 10) {
				updatePeriodic();
				radio.counter = 0;
			}
		}

		updatePeriodic();
		setInterval(periodic, 1000);



	});
</script>

<script>
// stripped down version of https://ocv.me/dev/iceplay.html
(function() {
	console.log(Date.now(), 'ayy');

	function ebi(id) {
		return document.getElementById(id);
	}

	function bust(url) {
		return url + '?_=' + Date.now();
	}

	var vol = 0.8,
		url_stream = '//stream.r-a-d.io/main.mp3',
		dom_btn = ebi('stream-play'),
		dom_vol = ebi('volume'),
		is_playing = false,
		start_grace = 99,
		last_pos = -99,
		audio = null;

	ev_stop();
	dom_btn.onclick = ev_start;
	dom_btn.classList.remove('disabled');

	////
	//// volume contorl
	////

	$('#volume').on("input change", function(ev) {
		vol = $(this).val() / 100.0;
		setvol();
	});

	// persist and apply volume to player
	function setvol() {
		if (audio)
			audio.volume = Math.pow(vol, 2.0);
			// not quite exponential but "sounds right"

		try {
			localStorage.setItem('volume', Math.floor(vol * 100));
		}
		catch (ex) {}

		$("#volume").val(vol * 100);
	}

	// load volume preference
	try {
		var v = localStorage.getItem('volume');
		if (v !== null)
			vol = parseInt(v) / 100.0;

		setvol();
	}
	catch (ex) {}

	////
	//// media control
	////

	// fully reinit the player (safe since it's a UI event)
	function ev_start() {
		ev_stop();
		start();
	}

	// starts playback of `url_stream`
	function start() {
		dom_btn.onclick = ev_stop;
		dom_btn.innerHTML = 'Connecting...';

		$("#volume-image").hide();
		$("#volume-control").show();

		if (!audio) {
			audio = new Audio();
			audio.addEventListener('error', recover, true);
		}
		is_playing = true;
		start_grace = 3;
		last_pos = -99;
		setvol();

		var url = bust(url_stream);
		console.log(Date.now(), url);
		audio.src = url;
		var rv = audio.play();
		if (!rv || !rv.then || !rv.catch) {
			check_started();
			return;
		}

		// newer browsers return a promise; helps to identify issues
		rv.then(check_started, function(err) {
			dom_btn.innerHTML = 'oh fucking';
			console.log(Date.now(), 'reject: ' + err);
		});
	}

	// check if start() worked after the promise fires
	function check_started() {
		if (audio.paused) {
			stop();
			dom_btn.innerHTML = 'uhh try again';
			return;
		}
		dom_btn.innerHTML = 'Stop Stream';
	}

	// after 1 sec, try to restart the stream without a UI event
	function recover() {
		dom_btn.onclick = ev_start;
		dom_btn.innerHTML = 'Reconnecting...';
		console.log(Date.now(), 'error ' + audio.error.code);
		if (audio.error.message)
			console.log(Date.now(), 'error ' + audio.error.code + ', ' + audio.error.message);
	}

	// stop playback;
	// requires a full reinit from a UI event to resume
	function ev_stop() {
		stop();
		audio = null;
	}

	// stop playback;
	// usuallyTM allows a non-event start() after
	function stop() {
		dom_btn.onclick = ev_start;
		dom_btn.innerHTML = 'Play Stream';

		is_playing = false;

		if (audio)
			audio.pause();

		$("#volume-control").hide();
		$("#volume-image").show();
	}

	// check if playback has progressed every 3 sec,
	// try to reconnect if that's not the case
	function monitor() {
		if (is_playing) {
			var pos = audio.currentTime;
			if (start_grace > 0) {
				start_grace--;
				console.log(Date.now(), "monitor grace", start_grace, "@", pos);
			}
			else if (pos > 0 && pos <= last_pos) {
				console.log(Date.now(), "reconnecting", pos);
				start();
			}
			last_pos = pos;
		}
		setTimeout(monitor, 3000);
	}
	console.log(Date.now(), 'starting monitor')
	monitor();
})();
</script>

<!-- rave lol -->
<script>
	if (localStorage.getItem("isRave") === "true" ) {
		ravemode();
	}

	document.getElementById("ravetoggle").addEventListener("click", enablerave);
	if (localStorage.getItem("isRave") === null) {
		localStorage.setItem("isRave", "false");
	}

	function enablerave() {
		if (localStorage.getItem("isRave") === "false" ) {
			localStorage.setItem("isRave", "true");
			window.location.href = window.location.href;
		} else {
			localStorage.setItem("isRave", "false");
			window.location.href = window.location.href;
		}
	}

	function ravemode() {
		if (localStorage.getItem("isRave") === "true") {
			document.getElementsByTagName("head")[0].insertAdjacentHTML(
			"beforeend",
			"<link rel=\"stylesheet\" href=\"/css/rave.css\" />");
			document.getElementById("ravetoggle").getElementsByTagName('a')[0].innerHTML = "Disable rave theme";
			document.getElementById("dj-image").addEventListener("click", spinfasterfaggot);
			document.getElementById("dj-image").style.animation = "djRotate 2s linear 0s infinite";
			document.getElementById("logo-image-container").getElementsByTagName('div')[0].getElementsByTagName('img')[0].addEventListener("click", shakeintensifies);

			var speed = 2;
			var multi = 1;

			function spinfasterfaggot() {
				speed = speed / 1.5;
				document.getElementById("dj-image").style.animation = "djRotate " + speed + "s linear 0s infinite";
				console.log("hello");
			}

			function shakeintensifies() {
				multi = multi + 1;
				document.getElementById("logo-image-container").getElementsByTagName('div')[0].getElementsByTagName('img')[0].animate([
					{ transform: 'translate(' + multi * 2 + 'px, ' + multi * 1 + 'px) rotate(' + multi * 0 + 'deg)' },
					{ transform: 'translate(' + multi * -1 + 'px, ' + multi * -2 + 'px) rotate(' + multi * -1 + 'deg)' },
					{ transform: 'translate(' + multi * -3 + 'px, ' + multi * 0 + 'px) rotate(' + multi * 1 + 'deg)' },
					{ transform: 'translate(' + multi * 0 + 'px, ' + multi * 2 + 'px) rotate(' + multi * 0 + 'deg)' },
					{ transform: 'translate(' + multi * 1 + 'px, ' + multi * -1 + 'px) rotate(' + multi * 1 + 'deg)' },
					{ transform: 'translate(' + multi * -1 + 'px, ' + multi * 2 + 'px) rotate(' + multi * -1 + 'deg)' },
					{ transform: 'translate(' + multi * -3 + 'px, ' + multi * 1 + 'px) rotate(' + multi * 0 + 'deg)' },
					{ transform: 'translate(' + multi * 2 + 'px, ' + multi * 1 + 'px) rotate(' + multi * -1 + 'deg)' },
					{ transform: 'translate(' + multi * -1 + 'px, ' + multi * -1 + 'px) rotate(' + multi * 1 + 'deg)' },
					{ transform: 'translate(' + multi * 2 + 'px, ' + multi * 2 + 'px) rotate(' + multi * 0 + 'deg)' },
					{ transform: 'translate(' + multi * 1 + 'px, ' + multi * -2 + 'px) rotate(' + multi * -1 + 'deg)' }
				], {
					duration: 500,
					iterations: Infinity
				});
			}
		}
	}
</script>
<!-- rave end -->
