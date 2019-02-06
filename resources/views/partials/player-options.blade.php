<button class="btn btn-primary btn-block disabled" id="stream-play" data-loading-text="{{{ trans("stream.loading") }}}"><i class="fa fa-spinner fa-spin"></i></button>
<button class="btn btn-primary btn-block" id="stream-stop" data-loading-text="{{{ trans("stream.loading") }}}" style="display: none; margin-top: 0;">{{{ trans("stream.stop") }}}</button>
<div class="btn-group btn-block" style="width:100%">
	<button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">
		{{{ trans("stream.options") }}} <span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu" style="width: 100%">
		<li><a href="https://stream.r-a-d.io/main.mp3">{{{ trans("stream.links.direct") }}}</a></li>
		<li><a href="/assets/main.mp3.m3u">{{{ trans("stream.links.m3u") }}}</a></li>
		<li><a href="/assets/main.pls">{{{ trans("stream.links.pls") }}}</a></li>
		<li class="divider"></li>
		@if (!$cur_theme)
			<li class="active"><a href="/set-theme/-1">Use DJ Theme</a></li>
		@else
			<li><a href="/set-theme/-1">Use DJ Theme</a></li>
		@endif
		@foreach ($themes as $t)
			@if ($t->display_name != "")
				@if ($t->name === $cur_theme)
					<li class="active"><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></li>
				@else
					<li><a href="/set-theme/{{ $t->id }}">{{{ $t->display_name }}}</a></li>
				@endif
			@endif
		@endforeach
		<li class="divider"></li>
		<li><a href="#help" data-toggle="modal" data-target="#help">{{{ trans("stream.links.help") }}}</a></li>
	</ul>
</div>
