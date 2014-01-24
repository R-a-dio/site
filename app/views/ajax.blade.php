<section class="radio-content-panel" data-uri="{{{ Request::path() == "/" ? "/" : "/" . Request::path() }}}" style="display: none;">
	@yield("content", '<div class="container">Some idiot forgot to render a view properly.</div>')
	@yield("script")
</section>
