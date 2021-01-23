function hasGetUserMedia() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
        return true;
    else
        return false;
}

function createSticker(src) {
    var sticker = document.createElement("img");

    sticker.src = src;
    sticker.style.position = "absolute";
    sticker.style.top = "0px";
    sticker.style.left = "50%";
    sticker.style.transform = "translate(-50%)";

    return sticker;
}
