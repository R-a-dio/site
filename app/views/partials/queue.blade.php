<h3 class="text-center">{{ trans("stream.queue") }}</h3>
<ul class="list-group" id="queue">
	@foreach (array_slice($curqueue, 0, $count) as $queue)
		@if ($queue["type"] > 0)
			<li class="list-group-item list-group-item-info queue" style="overflow-y: auto">
		@else
			<li class="list-group-item queue" style="overflow-y: auto">
		@endif
			<div class="col-md-8 text-center q-meta" style="line-height: 1">
				{{{ $queue["meta"] }}}
			</div>
			<div class="col-md-4 text-right q-time">
				{{ time_ago($queue["time"]) }}
			</div>
		</li>
	@endforeach
</ul>
