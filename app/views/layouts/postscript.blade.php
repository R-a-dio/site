<!-- Bootstrap core JavaScript
	================================================== -->
<!-- script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script -->
<script src="/js/bootstrap-3.1.0.min.js"></script>
<script src="/js/jquery.timeago.js"></script>
<!-- History.js -->
<script src="/js/jquery.history.js"></script>
<script src="/js/jquery.jplayer.min.js"></script>
<script src="/js/konami.js"></script>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-42658381-1', 'auto');
	ga('send', 'pageview');
</script>

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

		if (supports_html5_storage()) {

			if (!localStorage["volume"]) {
				localStorage["volume"] = 80;
			}
			$("#volume").val(parseInt(localStorage["volume"]));

		} else {
			$("#volume").val(80);
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


			if (History.getState().url.replace(History.getRootUrl(), "/") == "/") {
				$("#stream").jPlayer({
					ready: function () {
						$("#stream-play").text("{{{ trans("stream.play") }}}").removeClass("disabled");
						$("#stream-play").click(function() {
							if(window.player_source_set == false) {
								$("#stream").jPlayer("setMedia", {'mp3': location.protocol + '//stream.r-a-d.io/main.mp3'});
								window.player_source_set = true;
								$("#stream").jPlayer("play");
								$(this).hide();
								$("#volume-image").hide();
								$("#stream-stop").show();
								$("#volume-control").show();
							}
						});
						$("#stream-stop").click(function() {
							$("#stream").jPlayer("pause");
							$(this).hide();
							$("#stream-play").show();
						});
					},
					pause: function() {
						$("#stream").jPlayer("clearMedia");
						$("#volume-control").hide();
						$("#volume-image").show();
						window.player_source_set = false;
						$("#stream-play").click(function() {
							if(window.player_source_set == false) {
								$("#stream").jPlayer("setMedia", {'mp3': location.protocol + '//stream.r-a-d.io/main.mp3'});
								window.player_source_set = true;
								$("#stream").jPlayer("play");
							}
						});
					},
					volume: Math.pow(($("#volume").val() / 100), 2.0),
					supplied: "mp3",
					swfPath: swfpath
				});
			}
			
			$("#volume").on("input change", function (event) {
				if (supports_html5_storage()) {
					localStorage["volume"] = $(this).val();
				}
				$("#stream").jPlayer("volume", Math.pow(($(this).val() / 100), 2.0));
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
			radio.thread = resp.main.thread;
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
				radio.update_progress_inc = 100 / radio.duration * 0.5;
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
			radio.counter += 0.5;
			radio.current_pos += 0.5;
			applyProgress();
			if (radio.counter >= 10.0) {
				updatePeriodic();
				radio.counter = 0;
			}
		}

		updatePeriodic();
		setInterval(periodic, 500);



	});
</script>
