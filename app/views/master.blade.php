<!doctype html>
<html>
	<head>
		@include("layouts.head")
	</head>

	<body>
		@include("layouts.navbar")

		@yield("content", '<div class="container main">Some idiot forgot to render a view properly.</div>')

		@include("layouts.footer")

		@include("layouts.postscript")

		@yield("script", "")
	</body>
</html>
