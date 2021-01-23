function hasGetUserMedia() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
        return true;
    else
        return false;
}

// Create a new sticker.
function createSticker(src) {
    var sticker = document.createElement("img");

    sticker.src = src;
    sticker.style.position = "absolute";
    sticker.style.top = "0px";
    sticker.style.left = "50%";
    sticker.style.transform = "translate(-50%)";

    return sticker;
}

function removeStickers(parent)
{
    var old_stickers = parent.querySelectorAll("img");

    old_stickers.forEach((elem) => elem.remove());
}