document.getElementById("save-preferences").addEventListener("click", saveUserPreferences);

if (localStorage.getItem("mute-tags-internal") === null) { localStorage.setItem("mute-tags-internal", ""); }
if (localStorage.getItem("mute-tags-title") === null) { localStorage.setItem("mute-tags-title", ""); }
if (localStorage.getItem("mute-tags-play-instead") === null) { localStorage.setItem("mute-tags-play-instead", ""); }
if (localStorage.getItem("customSongVolume") === null) { localStorage.setItem("customSongVolume", "10"); }

if (localStorage.getItem("mute-tags-internal") != "") { document.getElementById("mute-tags-internal").value = localStorage.getItem("mute-tags-internal"); }
if (localStorage.getItem("mute-tags-title") != "") { document.getElementById("mute-tags-title").value = localStorage.getItem("mute-tags-title"); }
if (localStorage.getItem("mute-tags-play-instead") != "") { document.getElementById("mute-tags-play-instead").value = localStorage.getItem("mute-tags-play-instead"); }
document.getElementById("custom-song-volume").value = localStorage.getItem("customSongVolume");

let muteTagsInternalArray = localStorage.getItem("mute-tags-internal").split(",");
let muteTagsTitleArray = localStorage.getItem("mute-tags-title").split(",");
let muteTagsPlayInsteadArray = localStorage.getItem("mute-tags-play-instead").split(",");

var playInsteadSongPlaying = false;

function saveUserPreferences() {
    let fooMuteTagsInternal = "";
    document.getElementById("mute-tags-internal").value.toLowerCase().split(",").forEach(tag => fooMuteTagsInternal += tag.trim() + ",");
    fooMuteTagsInternal = fooMuteTagsInternal.slice(0, -1);
    let fooMuteTagsTitle = "";
    document.getElementById("mute-tags-title").value.toLowerCase().split(",").forEach(tag => fooMuteTagsTitle += tag.trim() + ",");
    fooMuteTagsTitle = fooMuteTagsTitle.slice(0, -1);
    let fooMuteTagsPlayInstead = "";
    document.getElementById("mute-tags-play-instead").value.split(",").forEach(tag => fooMuteTagsPlayInstead += tag.trim() + ",");
    fooMuteTagsPlayInstead = fooMuteTagsPlayInstead.slice(0, -1);

    localStorage.setItem("mute-tags-internal", fooMuteTagsInternal);
    localStorage.setItem("mute-tags-title", fooMuteTagsTitle);
    localStorage.setItem("mute-tags-play-instead", fooMuteTagsPlayInstead);
    localStorage.setItem("customSongVolume", document.getElementById("custom-song-volume").value);
}

function muteStream() {
    if (!window.iceplay.is_playing) {
        return;
    }

    if (muteTagsInternalArray.some(tag=> document.getElementById("tags").innerHTML.toLowerCase().includes(tag)) && muteTagsInternalArray[0] != "") {
        window.iceplay.audio.muted = true;
        if (muteTagsPlayInsteadArray[0] != "") {
            muteStreamPlaySomethingInstead();
            return;
        }
    } else if (muteTagsTitleArray.some(tag=> document.getElementById("np").innerHTML.toLowerCase().includes(tag)) && muteTagsTitleArray[0] != "") {
        window.iceplay.audio.muted = true;
        if (muteTagsPlayInsteadArray[0] != "") {
            muteStreamPlaySomethingInstead();
            return;
        }
    } else if (playInsteadSongPlaying) {
        window.iceplay.audio.muted = true;
        return;
    } else {
        window.iceplay.audio.muted = false;
    }
}

function setSongPlayingFalse() {
    playInsteadSongPlaying = false;
}

function muteStreamPlaySomethingInstead() {
    if (!playInsteadSongPlaying) {
        playInsteadSongPlaying = true;
        var randomSongIndex = Math.floor(Math.random()*muteTagsPlayInsteadArray.length);
        var customSong = new Audio(muteTagsPlayInsteadArray[randomSongIndex]);
        customSong.onloadedmetadata = function () {
            clearInterval(muteStreamInterval);
            setTimeout(function () {setInterval(muteStream, 5000), customSong.duration * 1000});
            setTimeout(setSongPlayingFalse, customSong.duration * 1000);
            customSong.volume = localStorage.getItem("customSongVolume") / 100;
            customSong.play();
        }
    }
}

if (muteTagsInternalArray[0] != "" || muteTagsTitleArray[0] != "") {
    var muteStreamInterval = setInterval(muteStream, 5000);
}
