@section('content')

<div class="container main content disable">
	<!-- Search Bar -->
	<div class="container search">
		<div class="col-md-7 centered">
			<h1 class="text-center text-info"> {{{ trans("search.help.main") }}} </h1>
			{!! Form::open(['url' => "/search", "class" => "ajax-search"]) !!}
				<div class="input-group">
					<input type="text" class="form-control" placeholder="{{{ trans("search.placeholder") }}}" name="q" id="search" value="{{{ $param }}}">
					<div class="input-group-btn">
						<button class="btn btn-info" type="submit">
							{{{ trans("search.button") }}}
						</button>
					</div>
				</div>
			{!! Form::close() !!}

		</div>
		<hr>
		<div class="col-md-7 centered">
			<!--<h2 class="text-center text-warning"> {{{ trans("search.help.options") }}} </h2>-->
			<h2 class="text-center text-warning"><span style="color:red;">new!!!</span> Click on a song to show tags </h2>
			<h6 class="text-center text-warning" id="always-show-tags-toggle" > or click this to show all tags 
</h2>

		</div>
	</div>

	<!-- Search Results -->
	<div class="container search">
		<div class="row visible-md visible-lg">
				<div class="col-sm-4 text-center" style="margin-bottom: 10px">
					<h4>{{{ trans("search.metadata.artist") }}}</h4>
				</div>
				<div class="col-sm-4 text-center" style="margin-bottom: 10px">
					<h4>{{{ trans("search.metadata.title") }}}</h4>
				</div>
				<!--
				<div class="col-sm-1 text-center" style="margin-bottom: 10px">
					<h4>{{{ trans("search.fave") }}}</h4>
				</div>
				-->
				<div class="col-sm-4 text-center" style="margin-bottom: 10px">
					<h4>{{{ trans("search.requestable") }}}</h4>
				</div>
		</div>
		<hr style="margin-top: 3px; margin-bottom: 8px;">

		@foreach ($results as $result)
			<div class="row song-search-row">
				<div class="col-sm-4 text-center" style="margin-bottom: 10px">
					<span class="text-danger">{{{ $result["_source"]["artist"] }}}</span>
				</div>
				<div class="col-sm-4 text-center" style="margin-bottom: 10px">
					<span class="text-info">{{{ $result["_source"]["title"] }}}</span>
				</div>
				<!--
				<div class="col-sm-1" style="margin-bottom: 10px">
					<button class="btn btn-block btn-danger fave-button" data-toggle="modal" data-target="#faves">
						<i class="fa fa-heart"></i>
					</button>
				</div>
				-->
				<div class="col-sm-4" style="margin-bottom: 10px">
					@if (requestable($result["_source"]["lastrequested"], $result["_source"]["requests"]) && requestable($result["_source"]["lastplayed"], $result["_source"]["requests"]))
						{!! Form::open(["url" => "/request/{$result["_id"]}"]) !!}
							<button type="submit" name="id" value="{{ $result["_id"] }}" class="btn btn-block btn-success request-button">
								{{{ trans("search.request") }}}
							</button>
						{!! Form::close() !!}
					@else
						<button class="btn btn-block btn-danger request-button disabled">
							{{{ pretty_cooldown($result["_source"]["lastrequested"], $result["_source"]["lastplayed"], $result["_source"]["requests"]) }}}
						</button>
					@endif
				</div>
				<div class="col-sm-12 text-center" id="search-tagline" style="display:none;margin-bottom:10px;"><b>{{{ $result["_source"]["tags"] }}}</b></div>
			</div>	
			<hr style="margin-top: 3px; margin-bottom: 8px;">
		@endforeach
		<div class="text-center text-success">
			@if (isset($time) and $time)
				<small>Query took {{{ $time }}}ms</small>
			@endif
		</div>
		<div class="text-center">
			{!! $results->render() !!}
		</div>
		

	</div>


<div class="modal fade" id="requests">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{{{ trans("search.request") }}}</h4>
			</div>
			<p class="modal-body"></p>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
<div class="modal fade" id="faves">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{{{ trans("search.fave") }}}</h4>
			</div>
			<p class="modal-body">Sorry, faves are not implemented yet.</p>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content - ->
	</div><!-- /.modal-dialog - ->
</div><!-- /.modal - ->
-->

<script>
if (localStorage.getItem("showSearchTags") === null) { localStorage.setItem("showSearchTags", "false"); }
if (localStorage.getItem("showSearchTags") == "true") { displayTags(); }

function showsearchsongtags() {
  if (this.querySelector("#search-tagline").style.display=="none") { 
    this.querySelector("#search-tagline").style.display = "unset";
  } else {   
    this.querySelector("#search-tagline").style.display = "none";
  } 
}  
 
function displayTags() {
  if (localStorage.getItem("showSearchTags") == "true") {
        Array.from(document.getElementsByClassName("song-search-row")).forEach(row => {
            row.querySelector("#search-tagline").style.display = "unset";
        }       
    )}
}
 
function toggleShowSearchTags() {
  localStorage.getItem("showSearchTags") == "true" ? localStorage.setItem("showSearchTags", "false") : 
localStorage.setItem("showSearchTags", "true");
}
 
Array.from(document.getElementsByClassName("song-search-row")).forEach(row => {
  row.style.cursor = "pointer";
  row.addEventListener("click", showsearchsongtags);
})  

document.getElementById("always-show-tags-toggle").addEventListener("click", function() {
  Array.from(document.getElementsByClassName("song-search-row")).forEach(row => {
    if (row.querySelector("#search-tagline").style.display=="none") {    
            row.querySelector("#search-tagline").style.display = "unset";
        } else {
            row.querySelector("#search-tagline").style.display = "none";
        } 
    })
})  

document.getElementById("always-show-tags-toggle").style.cursor = "pointer";
document.getElementById("always-show-tags-toggle").addEventListener("click", toggleShowSearchTags);
</script>

</div>

@stop

@section('script')

@stop
