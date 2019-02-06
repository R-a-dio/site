<script>
	$(".themebutton").click(function() {
		$(".themes").toggle(500);
		$(".players").hide();
		if( $("#ghosts").css("display") == 'none' ){
			$("#ghosts").fadeTo(500, 1);
		}
		else{
			$("#ghosts").fadeOut(500);
		}
	});
	

	
	$(".playerbutton").click(function() {
		$(".players").toggle(500);
		$(".listens").hide();
		$(".themes").hide();
		if( $("#ghosts").css("display") == 'none' ){
			$("#ghosts").fadeTo(500, 1);
		}
		else{
			$("#ghosts").fadeOut(500);
		}
	});
	
	$(".listenbutton").click(function() {
		$(".listens").toggle(500);
		$(".players").hide(500);
		if( $("#ghosts").css("display") == 'none' ){
			$("#ghosts").fadeTo(500, 1);
		}
		else{
			$("#ghosts").fadeOut(500);
		}
	});
	
	$(".helpbutton").click(function() {
		$(".helps").show(500);
		$("#help").show(500);
		$(".midvert").hide(500);
	});
	
	$(".stophelp").click(function() {
		$(".helps").toggle(500);
		$("#help").toggle(500);
		$(".midvert").show(500);
	});
</script>