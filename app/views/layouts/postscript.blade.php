        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="{{ $base }}/js/bootstrap.min.js"></script>
        <!-- jQuery ScrollTo Plugin -->
        <script src="{{ $base }}/js/jquery.scrollto.js"></script>

        <!-- History.js -->
        <script src="{{ $base }}/js/jquery.history.js"></script>

		<script>
			$(function() {
				volumeOpen = false;
				$('#nav-control').popover({
					content: '<div class="progress" style="width: 150px; margin-bottom: 0;"><div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="sr-only">60% Complete</span></div></div>',
					placement: 'bottom',
					delay: { show: 50, hide: 20 },
					html: true,
					trigger: 'manual'
				});

				$("#nav-control").mouseenter(function(event) {
					if (!volumeOpen) {
						volumeOpen = true;
						$("#nav-control").popover('show');

						$("#nav-control + .popover > div.popover-content").mouseleave(function(event) {
							if (volumeOpen) {
								volumeOpen = false;
								$("#nav-control").popover('hide');
							}
						});
						$(".navbar-collapse").mouseleave(function(event) {
							if (volumeOpen) {
								volumeOpen = false;
								$("#nav-control").popover('hide');
							}
						});
					}
				});

				
				
			});
		</script>