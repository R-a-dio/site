window.iceplay.addEventListener('connected', visualizer);

function init_visualizer() {
    document.getElementsByTagName('head')[0].insertAdjacentHTML('beforeend', '<link rel="stylesheet"href="/css/rave.css">');
    document.getElementsByTagName('footer')[0].insertAdjacentHTML('afterend', '<canvas id="canvas"></canvas>');
    window.visualizer_init = true;
}

function visualizer() {
    if (!window.iceplay.is_playing) return;
    if (!window.visualizer_init) init_visualizer();

    var context = new AudioContext();
    var src = context.createMediaElementSource(window.iceplay.audio);
    var analyser = context.createAnalyser();

    var canvas = document.getElementById("canvas");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    var ctx = canvas.getContext("2d");

    src.connect(analyser);
    analyser.connect(context.destination);

    analyser.fftSize = 512;

    var bufferLength = analyser.frequencyBinCount;

    var dataArray = new Uint8Array(bufferLength);

    var WIDTH = canvas.width;
    var HEIGHT = canvas.height;

    var barWidth = (WIDTH / bufferLength) * 2.5;
    var barHeight;
    var x = 0;

    function renderFrame() {
        requestAnimationFrame(renderFrame);

        x = 0;

        analyser.getByteFrequencyData(dataArray);

        ctx.fillStyle = "#222";
        ctx.fillRect(0, 0, WIDTH, HEIGHT);

        for (var i = 0; i < bufferLength; i++) {
			barHeight = dataArray[i];

            var r = barHeight + (25 * (i / bufferLength));
            var g = 250 * (i / bufferLength);
            var b = 50;

            // high frequencies are generally low, add a linear boost
            barHeight += Math.floor(barHeight * (i * 1.0 / bufferLength));

            ctx.fillStyle = "rgb(" + r + "," + g + "," + b + ")";
            ctx.fillRect(x, HEIGHT - barHeight, barWidth, barHeight * 2);

            x += barWidth + 1;
        }
    }
    renderFrame();
};

visualizer();
