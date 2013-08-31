<!doctype html>
<html>
	<head>
		@include('layouts.head')
	</head>

	<body>
		@include('layouts.header')

		@yield('content')

		@include('layouts.footer')

		@include('layouts.postscript')
	</body>
</html>