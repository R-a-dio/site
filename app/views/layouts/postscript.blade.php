	<!-- Bootstrap core JavaScript
		================================================== -->
	<script src="https://code.jquery.com/jquery-2.0.3.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

	<!-- jQuery ScrollTo Plugin -->
	<script src="/js/jquery.scrollto.js"></script>
	<script src="/js/jquery.timeago.js"></script>
	<!-- History.js -->
	<script src="/js/jquery.history.js"></script>
	<script src="/js/radio.player.js"></script>
	<script src="/js/furigana.js"></script>
	<script>
		$(function() {
			$.timeago.settings.allowFuture = true;
			$.timeago.settings.strings.minutes = "%d mins";
			$.timeago.settings.strings.minute = "less than a min";
			$.timeago.settings.strings.seconds = "less than a min";
			$.timeago.settings.strings.suffixFromNow = null;
			$.timeago.settings.strings.prefixFromNow = "in";

			function handlers() {
				$("time.timeago").timeago();
			}
			handlers();

			// Ajaxify
			$('a.ajax-navigation').click(function(event) {

				// Continue as normal for cmd clicks etc
				if (event.which == 2 || event.metaKey) { return true; }

				event.preventDefault();

				History.pushState(null, $(this).text(), $(this).attr("href"));
				
				return false;
			});

			$(window).on("statechange", function(event) {
				var state = History.getState();
				var root = History.getRootUrl();

				var uri = state.url.replace(root, "/");

				var $next = $("[data-uri='" + uri + "']");

				if ($next.length) {
					// we've been to this page before.
					var $current = $("#radio-container > .current");

					$current.removeClass("current").fadeOut();
					$next.addClass("current").fadeIn();
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

								$current.removeClass("current").fadeOut();
								$section.appendTo($("#radio-container")).addClass("current").fadeIn();

							}
						}
					})
				}

			});


		});
	</script>
