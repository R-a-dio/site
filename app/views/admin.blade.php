<!doctype html>
<html>
	<head>
		@include("admin.head")
	</head>

	<body>
		@include("admin.navbar")

		@yield("content", '<div class="container main">Some idiot forgot to render a view properly.</div>')

		@include("admin.footer")

		@include("admin.postscript")

		@yield("script", "")
	</body>
</html>
