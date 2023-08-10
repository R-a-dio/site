var ravespeed = 2;
var ravemulti = 1;

if (localStorage.getItem("isRave") === "true") {
    ravemode();
    rave_visualizer();
}
document.getElementById("ravetoggle").addEventListener("click", enablerave);
if (localStorage.getItem("isRave") === null) {
    localStorage.setItem("isRave", "false");
}
function enablerave() {
    if (localStorage.getItem("isRave") === "false") {
        localStorage.setItem("isRave", "true");
        window.location.href = window.location.href;
    } else {
        localStorage.setItem("isRave", "false");
        window.location.href = window.location.href;
    }
}
function ravemode() {
    document.getElementsByTagName("head")[0].insertAdjacentHTML("beforeend", "<link rel=\"stylesheet\" href=\"/css/rave.css\" />");
    document.getElementById("ravetoggle").getElementsByTagName('a')[0].innerHTML = "Disable rave theme";
    document.getElementById("dj-image").addEventListener("click", spinfaster);
    document.getElementById("dj-image").style.animation = "djRotate 2s linear 0s infinite";
    document.getElementById("logo-image-container").getElementsByTagName('div')[0].getElementsByTagName('img')[0].addEventListener("click", shakeintensifies);
    function spinfaster() {
        ravespeed = ravespeed / 1.5;
        document.getElementById("dj-image").style.animation = "djRotate " + ravespeed + "s linear 0s infinite";
    }
    function shakeintensifies() {
        ravemulti = ravemulti + 1;
        document.getElementById("logo-image-container").getElementsByTagName('div')[0].getElementsByTagName('img')[0].animate([
            {
                transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
            },
            {
                transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
            },
            {
                transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * 0 + 'px) rotate(' + ravemulti * 1 + 'deg)'
            },
            {
                transform: 'translate(' + ravemulti * 0 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
            }, {
                transform: 'translate(' + ravemulti * 1 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
            }, {
                transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
            }, {
                transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
            }, {
                transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * -1 + 'deg)'
            }, {
                transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
            }, {
                transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
            }, {
                transform: 'translate(' + ravemulti * 1 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
            }
        ], {
            duration: 500,
            iterations: Infinity
        });

        let benis = Array.from(document.getElementsByClassName("thumbnail"));

        benis.forEach(ebin => {
            ebin.animate([
                {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * 0 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * 0 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 1 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 1 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }
            ], {
                duration: 500,
                iterations: Infinity
            });
        });

        let benis2 = Array.from(document.getElementsByClassName("col-md-4"));

        benis2.forEach(ebin => {
            ebin.animate([
                {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * 0 + 'px, ' + ravemulti * 0 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 0 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 1 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }
            ], {
                duration: 500,
                iterations: Infinity
            });
        });

        let benis3 = Array.from(document.getElementsByClassName("col-md-6"));

        benis3.forEach(ebin => {
            ebin.animate([
                {
                    transform: 'translate(' + ravemulti * 1 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 0 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                },
                {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 0 + 'px, ' + ravemulti * 1 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -3 + 'px, ' + ravemulti * -1 + 'px) rotate(' + ravemulti * 1 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * -1 + 'px, ' + ravemulti * 2 + 'px) rotate(' + ravemulti * 0 + 'deg)'
                }, {
                    transform: 'translate(' + ravemulti * 2 + 'px, ' + ravemulti * -2 + 'px) rotate(' + ravemulti * -1 + 'deg)'
                }
            ], {
                duration: 500,
                iterations: Infinity
            });
        });

    }
}

function rave_visualizer() {
    window.iceplay.addEventListener('connected', visualizer);

    function init_visualizer() {
        document.getElementsByTagName('head')[0].insertAdjacentHTML('beforeend', '<link rel="stylesheet"href="/css/rave.css">');
        document.getElementsByTagName('footer')[0].insertAdjacentHTML('afterend', '<canvas id="canvas"></canvas>');

        window.visualizer_init = true;
    }

    function visualizer() {
        if (!window.iceplay.is_playing) 
            return;
        
        if (!window.visualizer_init) 
            init_visualizer();
        

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

            ctx.fillStyle = "rgba(0, 0, 0, 0)";
            ctx.fillRect(0, 0, WIDTH, HEIGHT);
            ctx.clearRect(0, 0, WIDTH, HEIGHT);

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
}
