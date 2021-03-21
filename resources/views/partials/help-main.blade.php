<div class="modal fade bs-modal-lg" id="help">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">R/a/dio Help</h4>
			</div>
			<div class="modal-body">
				<h3>Playing the Stream</h3>
				<p>Simply click the <button class="btn btn-primary btn-sm">Play Stream</button> button in your browser.</p>
				<p>A volume slider will appear, and the slider will change the volume. This is remembered between page loads.</p>
				<p>To play the stream in your media player, you can use any of the following links:</p>
				<ul>
					<li><a href="https://stream.r-a-d.io/main">{{{ trans("stream.links.direct") }}}</a></li>
					<li><a href="/assets/main.mp3.m3u">{{{ trans("stream.links.m3u") }}}</a></li>
					<li><a href="/assets/main.pls">{{{ trans("stream.links.pls") }}}</a></li>
				</ul>

				<h3>Requesting Songs</h3>
				<p>Search for a song first, by entering something into the searchbox at the top (or clicking "Search" in the navbar).</p>
				<p>Then, click on <button class="btn btn-success btn-sm">Request</button></p>
				<p>You can only request every 30 minutes.</p>

				<h3>Submitting songs</h3>
				<p>Head over to the <a href="/submit">submit page</a> and read the instructions on the left <b>very carefully</b> before submitting a song.</p>
				<p>It can take some time for your submission to be reviewed and accepted (or declined).</p>
				<p>Your submission may be declined for a number of reasons including low quality, missing tags (meaning artist name, song name, source, etc.), but also sometimes because it's simply too niche and the majority of the listeners would likely rather not listen to it.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
