<h3 class="text-center">{{ trans("stream.lp") }}</h3>
<ul class="list-group" id="lastplayed">
	@foreach (array_slice($lastplayed, 0, $count) as $lp)
		<li class="list-group-item last-played" style="overflow-y: auto">
			<div class="col-md-4 lp-time">
				{{ time_ago($lp["time"]) }}
			</div>
			<div class="col-md-8 lp-meta text-center" style="line-height: 1">
				{{{ $lp["meta"] }}}
			</div>
		</li>
	@endforeach
</ul>
