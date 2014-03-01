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

		@yield("script", "")
	</body>
</html>
