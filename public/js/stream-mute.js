if (localStorage.getItem("muteTumors") === null) {
    localStorage.setItem("muteTumors", "false");
}

switch (localStorage.getItem("muteTumors")) {
    case "false":
        document.getElementById("mutetumors").children[0].innerHTML = "Mute vtuber songs";
        break;
    case "true":
        document.getElementById("mutetumors").children[0].innerHTML = "Unmute vtuber songs";
        break;
}
