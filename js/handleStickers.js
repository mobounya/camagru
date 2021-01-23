(function placeStickers() {
    var stickers = document.querySelectorAll("[data-role=sticker]");

    stickers.forEach(function addListener(img) {
        img.addEventListener("click", function imageClick() {
            console.log("Sticker clicked");
            live_video = document.getElementById("live-video");

            // Create new image and append to div container.
            var sticker = createSticker(img.src);
            live_video.appendChild(sticker);
        });
    });
})();
