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
			else if (new Date().getMonth() == 11 && new Date().getDate() < 26)
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

		function updateTags(tags, dj) {
			if(tags[0] === "") {
				document.getElementById("tags").innerHTML = "there are no tags for this song!";
			} else if (dj !== "Hanyuu-sama") {
				document.getElementById("tags").innerHTML = "tags can't be displayed while a dj is on!";
			} else {
				document.getElementById("tags").innerHTML = tags.join(" ");
			}
		}

		function setMediaSession(np, dj) {
			if (!('mediaSession' in navigator && window.MediaMetadata))
				return;

			var m = {},
				ofs = np.indexOf(' - ');

			m.title = np;
			m.artist = dj;
			m.album = dj + ' on r/a/dio';
			m.artwork = [{
				src: $("#dj-image").attr("src"),
				type: "image/png"
			}];

			if (ofs + 1) {
				m.artist = np.slice(0, ofs);
				m.title = np.slice(ofs + 3);
			}

			function playpause() {
				document.getElementById('stream-play').click();
			}

			navigator.mediaSession.metadata = new MediaMetadata(m);
			navigator.mediaSession.setActionHandler('play', playpause);
			navigator.mediaSession.setActionHandler('pause', playpause);
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
					updateTags(resp.main.tags, resp.main.dj.djname);
					setMediaSession(resp.main.np, resp.main.dj.djname);
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
window.iceplay = (function() {
	console.log(Date.now(), 'ayy');

	var ebi = document.getElementById.bind(document),
		events = {},
		r = {
			"vol": 0.8,
			"audio": null,
			"is_playing": false
		};
	
	r.addEventListener = function(name, handler) {
		if (events.hasOwnProperty(name))
			events[name].push(handler);
		else
			events[name] = [handler];
	};

	r.removeEventListener = function(name, handler) {
		if (!events.hasOwnProperty(name))
			return;

		var idx = events[name].indexOf(handler);
		if (idx !== -1)
			events[name].splice(idx, 1);
	};

	function emitEvent(name, args) {
		if (!events.hasOwnProperty(name))
			return;

		if (!args || !args.length)
			args = [];

		for (var a=0, aa=events[name].length; a<aa; a++)
			events[name][a].apply(null, args);
	};

	function bust(url) {
		return url + '?_=' + Date.now();
	}

	// TODO nginx config sets acao for relay0 but not stream.*
	var url_stream = '//relay0.r-a-d.io/main.mp3',
		dom_btn = ebi('stream-play'),
		dom_vol = ebi('volume'),
		start_grace = 99,
		last_pos = -99,
		fader_t = 0,
		fader_ref = 0,
		fader_v = 0;

	ev_stop();
	dom_btn.onclick = ev_start;
	dom_btn.classList.remove('disabled');

	////
	//// volume contorl
	////

	$('#volume').on("input change", function(ev) {
		r.vol = $(this).val() / 100.0;
		setvol();
	});

	// persist and apply volume to player
	function setvol(tempval) {
		if (r.audio)
			r.audio.volume = Math.pow(tempval || r.vol, 2.0);
			// not quite exponential but "sounds right"

		if (tempval)
			return;

		try {
			localStorage.setItem('volume', Math.floor(r.vol * 100));
		}
		catch (ex) {}

		$("#volume").val(r.vol * 100);
	}

	// load volume preference
	try {
		var v = localStorage.getItem('volume');
		if (v !== null)
			r.vol = parseInt(v) / 100.0;

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

		if (!r.audio) {
			r.audio = new Audio();
			r.audio.crossOrigin = 'anonymous';
			r.audio.addEventListener('error', recover, true);
		}
		r.is_playing = true;
		start_grace = 3;
		last_pos = -99;
		setvol();

		// let the fader handle it
		r.audio.volume = 0;
		fader_v = 0;

		var url = bust(url_stream);
		console.log(Date.now(), url);
		r.audio.src = url;
		var rv = r.audio.play();
		if (!rv || !rv.then || !rv.catch) {
			check_started();
			return;
		}

		// newer browsers return a promise; helps to identify issues
		rv.then(check_started, function(err) {
			dom_btn.innerHTML = 'oh fucking';
			console.log(Date.now(), 'reject: ' + err);
		});

		try {
			navigator.mediaSession.playbackState = "playing";
		}
		catch (e) { }
	}

	// check if start() worked after the promise fires
	function check_started() {
		if (r.audio.paused) {
			stop();
			dom_btn.innerHTML = 'uhh try again';
			return;
		}
		dom_btn.innerHTML = 'Stop Stream';
		emitEvent('connected');
		setTimeout(fade_in, 200);
	}

	function fade_in() {
		clearTimeout(fader_t);
		var apos = r.audio.currentTime;
		if (apos != fader_ref) {
			fader_ref = apos;
			if (r.vol - fader_v < 0.01) {
				setvol(fader_v);
				return;
			}
			fader_v = Math.min(fader_v + 0.03, r.vol);
			setvol(fader_v);
		}
		fader_t = setTimeout(fade_in, 20);
	}

	// after 1 sec, try to restart the stream without a UI event
	function recover() {
		dom_btn.onclick = ev_start;
		dom_btn.innerHTML = 'Reconnecting...';
		console.log(Date.now(), 'error ' + r.audio.error.code);
		if (r.audio.error.message)
			console.log(Date.now(), 'error ' + r.audio.error.code + ', ' + r.audio.error.message);
	}

	// stop playback;
	// requires a full reinit from a UI event to resume
	function ev_stop() {
		stop();
		r.audio = null;
	}

	// stop playback;
	// usuallyTM allows a non-event start() after
	function stop() {
		dom_btn.onclick = ev_start;
		dom_btn.innerHTML = 'Play Stream';

		r.is_playing = false;

		if (r.audio)
			r.audio.pause();

		$("#volume-control").hide();
		$("#volume-image").show();

		try {
			navigator.mediaSession.playbackState = "paused";
		}
		catch (e) { }
	}

	// check if playback has progressed every 3 sec,
	// try to reconnect if that's not the case
	function monitor() {
		if (r.is_playing) {
			var pos = r.audio.currentTime;
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
	return r;
})();
</script>
<script src="/js/rave.js"></script>
<script src="/js/tags.js"></script>
<!--<script src="/js/user-preferences.js"></script>-->
<script>
document.getElementById("save-preferences").addEventListener("click", saveUserPreferences);

if (localStorage.getItem("mute-tags-internal") === null) { localStorage.setItem("mute-tags-internal", ""); }
if (localStorage.getItem("mute-tags-title") === null) { localStorage.setItem("mute-tags-title", ""); }
if (localStorage.getItem("mute-tags-play-instead") === null) { localStorage.setItem("mute-tags-play-instead", ""); }
if (localStorage.getItem("customSongVolume") === null) { localStorage.setItem("customSongVolume", "10"); }
if (localStorage.getItem("mute-tags-stop-early") === null) { localStorage.setItem("mute-tags-stop-early", "false"); }

if (localStorage.getItem("mute-tags-internal") != "") { document.getElementById("mute-tags-internal").value = localStorage.getItem("mute-tags-internal"); }
if (localStorage.getItem("mute-tags-title") != "") { document.getElementById("mute-tags-title").value = localStorage.getItem("mute-tags-title"); }
if (localStorage.getItem("mute-tags-play-instead") != "") { document.getElementById("mute-tags-play-instead").value = localStorage.getItem("mute-tags-play-instead"); }
if (localStorage.getItem("mute-tags-stop-early") == "true") { document.getElementById("mute-tags-stop-early").checked = true; }

document.getElementById("custom-song-volume").value = localStorage.getItem("customSongVolume");

let muteTagsInternalArray = localStorage.getItem("mute-tags-internal").split(",");
let muteTagsTitleArray = localStorage.getItem("mute-tags-title").split(",");
let muteTagsPlayInsteadArray = localStorage.getItem("mute-tags-play-instead").split(",");

var playInsteadSongPlaying = false;

function saveUserPreferences() {
    let fooMuteTagsInternal = "";
    document.getElementById("mute-tags-internal").value.toLowerCase().split(",").forEach(tag => fooMuteTagsInternal += tag.trim() + ",");
    fooMuteTagsInternal = fooMuteTagsInternal.slice(0, -1);
    let fooMuteTagsTitle = "";
    document.getElementById("mute-tags-title").value.toLowerCase().split(",").forEach(tag => fooMuteTagsTitle += tag.trim() + ",");
    fooMuteTagsTitle = fooMuteTagsTitle.slice(0, -1);
    let fooMuteTagsPlayInstead = "";
    document.getElementById("mute-tags-play-instead").value.split(",").forEach(tag => fooMuteTagsPlayInstead += tag.trim() + ",");
    fooMuteTagsPlayInstead = fooMuteTagsPlayInstead.slice(0, -1);

    localStorage.setItem("mute-tags-internal", fooMuteTagsInternal);
    localStorage.setItem("mute-tags-title", fooMuteTagsTitle);
    localStorage.setItem("mute-tags-play-instead", fooMuteTagsPlayInstead);
    localStorage.setItem("customSongVolume", document.getElementById("custom-song-volume").value);
	localStorage.setItem("mute-tags-stop-early", document.getElementById("mute-tags-stop-early").checked === true ? "true" : "false");
}

function muteStream() {
    if (!window.iceplay.is_playing) {
        return;
    }

    if (muteTagsInternalArray.some(tag=> document.getElementById("tags").innerHTML.toLowerCase().includes(tag)) && muteTagsInternalArray[0] != "") {
        window.iceplay.audio.muted = true;
        if (muteTagsPlayInsteadArray[0] != "") {
            muteStreamPlaySomethingInstead();
            return;
        }
    } else if (muteTagsTitleArray.some(tag=> document.getElementById("np").innerHTML.toLowerCase().includes(tag)) && muteTagsTitleArray[0] != "") {
        window.iceplay.audio.muted = true;
        if (muteTagsPlayInsteadArray[0] != "") {
            muteStreamPlaySomethingInstead();
            return;
        }
	} else if (localStorage.getItem("mute-tags-stop-early") == "true" && typeof customSong != 'undefined') {
		customSong.pause();
		setSongPlayingFalse();
		window.iceplay.audio.muted = false;
		delete customSong;
    } else if (playInsteadSongPlaying) {
        window.iceplay.audio.muted = true;
        return;
    } else {
        window.iceplay.audio.muted = false;
    }
}

function setSongPlayingFalse() {
    playInsteadSongPlaying = false;
}

function muteStreamPlaySomethingInstead() {
    if (!playInsteadSongPlaying) {
        playInsteadSongPlaying = true;
        var randomSongIndex = Math.floor(Math.random()*muteTagsPlayInsteadArray.length);
        customSong = new Audio(muteTagsPlayInsteadArray[randomSongIndex]);
        customSong.onloadedmetadata = function () {
            //clearInterval(muteStreamInterval);
            //setTimeout(function () {setInterval(muteStream, 5000), customSong.duration * 1000});
            setTimeout(setSongPlayingFalse, customSong.duration * 1000);
            customSong.volume = localStorage.getItem("customSongVolume") / 100;
            customSong.play();
        }
    }
}

if (muteTagsInternalArray[0] != "" || muteTagsTitleArray[0] != "") {
    var muteStreamInterval = setInterval(muteStream, 5000);
}

// need to move the above to a separate file

</script>
