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
			
			$("#stream-player").click(function(event) {
				event.preventDefault();

				// save some vars
				var $btn = $(this);
				var $audio = $(audio);

				// generate a click event on the navbar instead
				$("#play").click();

				$btn.button("loading");

				$audio.on("loadeddata", function(event) {
					$btn.button("reset");
					$btn.text("throw new NotImplementedError();");
				});
			});
		</script>
