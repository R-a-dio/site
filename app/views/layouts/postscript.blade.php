        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="{{ $base }}/js/bootstrap.min.js"></script>
        <!-- jQuery ScrollTo Plugin -->
        <script src="{{ $base }}/js/jquery.scrollto.js"></script>

        <!-- History.js -->
        <script src="{{ $base }}/js/jquery.history.js"></script>

        <script src="{{ $base }}/js/jquery.jplayer.min.js"></script>


		<!-- YAY JAVASCRIPT -->
		<script src="{{ $base }}/js/lib/Three.js"></script>
		<script src="{{ $base }}/js/lib/Stats.js"></script>
		<script src="{{ $base }}/js/lib/Detector.js"></script>

		<script src="{{ $base }}/js/src/dancer.js"></script>
		<script src="{{ $base }}/js/src/support.js"></script>
		<script src="{{ $base }}/js/src/kick.js"></script>
		<script src="{{ $base }}/js/src/adapterWebkit.js"></script>
		<script src="{{ $base }}/js/src/adapterMoz.js"></script>
		<script src="{{ $base }}/js/src/adapterFlash.js"></script>
		<script src="{{ $base }}/js/lib/fft.js"></script>
		<script src="{{ $base }}/js/lib/flash_detect.js"></script>
		<script src="{{ $base }}/js/plugins/dancer.fft.js"></script>

		<!-- UNTZ UNTZ UNTZ -->
		<script src="{{ $base }}/js/scene.js"></script>
		<script src="{{ $base }}/js/player.js"></script>
		<script>
			(function () {
				var fft = document.getElementById( 'fft' );
				fft.style.display = 'block';
			})();
		</script>

		<script>
			audio = document.getElementById("stream");

			$("#play").click(function(event) {
				event.preventDefault();

				audio.load();
				audio.play();
			})
			/*$(function() {
				// config
				volumeOpen = false;
				ready = false;
				stopped = true;
				
				// stream URL. make configurable.
				var stream = {
					mp3: "https://r-a-d.io/main"
				}

				$('#nav-control').popover({
					content: '<div class="progress" style="width: 150px; margin-bottom: 0;"><div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="sr-only">60% Complete</span></div></div>',
					placement: 'bottom',
					delay: { show: 50, hide: 20 },
					html: true,
					trigger: 'manual'
				});

				// popover handling
				$("#nav-control").mouseenter(function() {
					if (!volumeOpen) {
						volumeOpen = true;
						$("#nav-control").popover('show');

						$("#nav-control + .popover > div.popover-content").mouseleave(function() {
							if (volumeOpen) {
								volumeOpen = false;
								$("#nav-control").popover('hide');
							}
						});
						$(".navbar-collapse").mouseleave(function() {
							if (volumeOpen) {
								volumeOpen = false;
								$("#nav-control").popover('hide');
							}
						});
					}
				});

				$("#nav-control").click(function(event) {

					event.preventDefault();

					if (stopped) { // need to play the stream
						console.log("Attempting to play audio...");
						$("a > i", this).attr("class", "icon-stop");
						stopped = false;

						$("#stream").jPlayer("play");

					} else { // need to stop the stream
						console.log("Attempting to stop audio...");
						$("a > i", this).attr("class", "icon-play");

						stopped = true;

						$("#stream").jPlayer("pause");
					}
				});
				

				$("#stream").jPlayer({
					ready: function () {
						console.log("ready");
						ready = true;
						$(this).jPlayer("setMedia", stream);
					},
					pause: function() {
						console.log("Attempting to stop"); 
						$(this).jPlayer("clearMedia");
					},
					error: function(event) {
						console.log(event.jPlayer.error);
						if(ready && (event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET
							|| event.jPlayer.error.type === $.jPlayer.error.URL)) {
							// Setup the media stream again and play it.
							$(this).jPlayer("setMedia", stream).jPlayer("play");
						}
					},
					swfPath: "{{ $base }}/js",
					supplied: "mp3",
					preload: "none",
					wmode: "window"
				});

				
			});*/
		</script>