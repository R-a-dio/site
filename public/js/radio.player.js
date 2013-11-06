$(function () {
    // Future-proofing...
    var context;
    if (typeof AudioContext !== "undefined") {
        context = new AudioContext();
    } else if (typeof webkitAudioContext !== "undefined") {
        context = new webkitAudioContext();
    } else {
        alert("Flash Fallback Needed. If you're on firefox, ff25 was released weeks ago. UPDATE DAMNIT.");
    }

    // Overkill - if we've got Web Audio API, surely we've got requestAnimationFrame. Surely?...
    // requestAnimationFrame polyfill by Erik M�ller
    // fixes from Paul Irish and Tino Zijdel
    // http://paulirish.com/2011/requestanimationframe-for-smart-animating/
    // http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame']
                                    || window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function (callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function () { callback(currTime + timeToCall); },
                timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function (id) {
            clearTimeout(id);
        };

    // Create the analyser
    var analyser = context.createAnalyser();
    analyser.fftSize = 64;
    var frequencyData = new Uint8Array(analyser.frequencyBinCount);

    // Set up the visualisation elements
    var visualisation = $("#visualisation");
    
	var barSpacingPercent = 100 / analyser.frequencyBinCount;
    for (var i = 0; i < analyser.frequencyBinCount; i++) {
    	$("<div></div>").css("left", i * barSpacingPercent + "%")
			.appendTo(visualisation);
    }
    var bars = $("#visualisation > div");

    // Get the frequency data and update the visualisation
    function update() {
        requestAnimationFrame(update);

        analyser.getByteFrequencyData(frequencyData);

        bars.each(function (index, bar) {
            bar.style.height = frequencyData[index] + 'px';
        });
    };

    // Hook up the audio routing...
    // player -> analyser -> speakers
	// (Do this after the player is ready to play - https://code.google.com/p/chromium/issues/detail?id=112368#c4)
	$("#player").bind('canplay', function() {
		var source = context.createMediaElementSource(this);
		source.connect(analyser);
		analyser.connect(context.destination);
	});

    // Kick it off...
    update();
});