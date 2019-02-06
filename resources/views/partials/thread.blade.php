<div class="well well-lg" id="dj-mode" style="display: none">
	@if ($status["thread"] === "none" or $status["thread"] === "None")
		<h2 class="text-center">There is currently no thread up.</h2>
	@else
		<h1 class="text-center thread"><a href="{{{ $status["thread"] }}}">Thread up!</a></h1>
	@endif
</div>
