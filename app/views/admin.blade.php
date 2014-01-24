<!doctype html>
<html>
	<head>
		@include("layout.head")
	</head>

	<body>
		@include("admin.navbar")

		@yield("content", '<div class="container main">Some idiot forgot to render a view properly.</div>')

		@include("admin.footer")

		@include("layout.postscript")

		@yield("script", "")
	</body>
</html>
