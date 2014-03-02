<!doctype html>
<html>
	<head>
		@include("layouts.head")
	</head>

	<body>
		@include("admin.navbar")

		@yield("content", '<div class="container main">Some idiot forgot to render a view properly.</div>')

		@include("admin.footer")

		<!-- Bootstrap core JavaScript
			================================================== -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
		<script src="/js/jquery.timeago.js"></script>
		<!-- History.js -->
		<script src="/js/jquery.history.js"></script>
		<script src="/js/jquery.jplayer.min.js"></script>
		<script src="/js/konami.js"></script>
		<script src="/js/aurora.js"></script>
		<script src="/js/flac.js"></script>
		<script src="/js/mp3.js"></script>
		<script>$("time.timeago").timeago();</script>
		<script>
			$("#volume").val(localStorage["volume"]);

			var avplayer, duration;

			function loadAudio(url) {

				avplayer = AV.Player.fromURL(url);

				callbacks();
				
			}

			function callbacks() {

				avplayer.on("duration", function (event) {
					duration = event;
				});

				avplayer.on("progress", function (event) {
					if (duration) {
						var raw = event / duration;
						var parsed = parseInt(raw * 1000);
						$("#audio-progress").val(parsed);

						var date = new Date(event);

						var mins = date.getUTCMinutes(),
							secs = date.getUTCSeconds();

						if (secs < 10) {
							secs = "0" + secs;
						}

						$("#audio-time").text(mins + ":" + secs);
					} else {
						$("#audio-time").text(".:..");
					}
				});

				avplayer.on("metadata", function (metadata) {
					var artist = metadata.artist,
						title = metadata.title;

					$("#np").text(artist + " - " + title);
				});

				avplayer.on("buffer", function(percent) {
					console.log(percent);
					$("#audio-buffer").css("width", percent + "%");

				});

				$("#audio-play").click(function (e) {
					e.preventDefault();

					avplayer.play();
					$(this).hide();
					$("#audio-pause").show();
				});

				$("#audio-pause").click(function (e) {
					e.preventDefault();

					avplayer.pause();
					$(this).hide();
					$("#audio-play").show();
				});

				$("#audio-reset").click(function (e) {
					e.preventDefault();

					reset(avplayer);
				});

				$("#audio-debug").click(function (e) {
					document.player = avplayer;
					console.log("Debug: document.player");
				});

				$("#audio-progress").change(function (e) {
					e.preventDefault();

					var percent = $(this).val() / 1000,
						raw = duration * percent;

					avplayer.seek(parseInt(raw));
					console.log(raw);

				});
				avplayer.volume = Math.pow(parseInt(localStorage["av-volume"]) / 10, 2.0);

				avplayer.play();
				$("#audio-play").hide();
				$("#audio-pause").show();

			}

			$(".play-button").click(function (e) {
				e.preventDefault();
				
				reset(avplayer);

				loadAudio($(this).attr("data-url"));
			});

			$("#volume").change(function (e) {
				var vol = $(this).val();

				// #CopyPastingEverything
				if (vol >= 70) {
					$("#volume-high").show();
					$("#volume-low").hide();
					$("#volume-muted").hide();
				} else if (vol < 70 && vol != 0) {
					$("#volume-high").hide();
					$("#volume-low").show();
					$("#volume-muted").hide();
				}  else {
					$("#volume-high").hide();
					$("#volume-low").hide();
					$("#volume-muted").show();
				}

				localStorage["av-volume"] = vol;


				$("#audio-bar").css("width", localStorage["av-volume"] + "%");

				if (avplayer)
					avplayer.volume = Math.pow(parseInt(localStorage["av-volume"]) / 10, 2.0);
			});

			if (localStorage["av-volume"]) {
				$("#volume").val(localStorage["av-volume"]);
				$("#audio-bar").css("width", localStorage["av-volume"] + "%");
			} else {
				localStorage["av-volume"] = 80;
			}
			function reset(player) {
				if (player)
					player.stop();
				$("#audio-buffer").css("width", "0%");
				$("#audio-progress").val(0);
				$("#audio-time").text("0:00");
			}

		</script>

		@yield("script", "")
	</body>
</html>
