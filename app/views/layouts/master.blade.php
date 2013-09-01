<!doctype html>
<html>
	<head>
		@include('layouts.head')
	</head>

	<body>
		@include('layouts.navbar')

		@yield('content')

		@include('layouts.footer')

		@include('layouts.postscript')
	</body>
</html>
