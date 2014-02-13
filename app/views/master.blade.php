<!doctype html>
<html>
	<head>
		@include("layouts.head")
	</head>

	<body>
		@include("layouts.navbar")
		
		<div id="radio-container">
			<section class="radio-content-panel current" data-uri="{{{ Request::path() == "/" ? "/" : "/" . Request::path() }}}">
				@yield("content", '<div class="container main">Some idiot forgot to render a view properly.</div>')
			</section>
		</div>
		
		@include("layouts.footer")

		@include("layouts.postscript")
		
		@include($script)
		
		@yield("script", "")
	</body>
</html>
