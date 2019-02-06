@section("content")

<div class="container main">

	<div class="staffpage-title col-md-12">
		<span id="return-to-staff">
			<h3>
				<!--There's probably a better way to do this-->
				<a href="javascript:history.back()"> << </a>
			</h3>
		</span>
		<span id="djprofile-name">
			<!--Whatever DJname the user clicked in staff or frontpage; I put Hanyuu as a placeholder-->
			<h3>Hanyuu</h3>
		</span>
	</div>
	
	<div class="djprofile-panel panel-default djpage-panel col-md-12 col-sm-12 col-xs-12">
	
			<div class="col-md-2 profile-block">
				<div class="djprofile-img">
					<!--The DJ image of whatever DJ the profile belongs to; I put Hanyuu as a placeholder-->
					<img src="/api/dj-image/18" alt="djname" height="150" width="150" style="max-height: 150px">
				</div>
			</div>
				
			<div class="col-md-5 profile-block">
				<div class="djprofile-info-one">
					<!--It would probably be good if the DJ could change this through their profile settings?-->
					<div id="dj-days"><h4>Day:</h4>
						<p>Every day~</p>
					</div>
					<!--Same goes for this.-->
					<div id="dj-times"><h4>Time:</h4>
						<p>All the time~</p>
					</div>
				</div>
			</div>
				
			<div class="col-md-5 separator profile-block">
				<div class="djprofile-info-two">
					<div>
						<!--And this. It might not be a bad idea to have this as a mouseover on the front/staffpage as was in the old site.-->
						<h4>Other:</h4>
						<p>Secondary fermentation degrees plato units of bitterness, cask conditioned ale ibu real ale pint glass craft beer. krausen goblet grainy ibu brewhouse lagering finishing hops. Trappist, black malt chocolate malt balthazar.</p>
					</div>
				</div>
			</div>
			
	</div>
	
</div>

@stop
