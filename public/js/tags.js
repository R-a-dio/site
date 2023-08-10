if (localStorage.getItem("displayTags") === null) {
    localStorage.setItem("displayTags", "false");
}

// add the tag part under currently playing song after checking it's display status
switch (localStorage.getItem("displayTags")) {
    case "false":
        document.getElementById("np").insertAdjacentHTML('afterend', '<p id="tags" style="font-size:14px;display:none;"></p>');
        break;
    case "true":
        document.getElementById("np").insertAdjacentHTML('afterend', '<p id="tags" style="font-size:14px;"></p>');
        break;
}

// add eventlistener to toggle display of tags when song title is clicked
document.getElementById("np").addEventListener("click", function () {
    switch (localStorage.getItem("displayTags")) {
        case "false":
            localStorage.setItem("displayTags", "true");
            document.getElementById("tags").style.display = "inherit";
            break;
        case "true":
            localStorage.setItem("displayTags", "false");
            document.getElementById("tags").style.display = "none";
            break;
    }
});

// also i set this here because changing this in the css file would be :effort:
document.getElementById("np").style.cursor = "pointer";
