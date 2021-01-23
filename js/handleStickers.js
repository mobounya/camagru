(function placeStickers() {
    // Load all stickers.
    var stickers = document.querySelectorAll("[data-role=sticker]");

    // Add event listener to each img object in stickers.
    stickers.forEach(function addListener(img) {
        img.addEventListener("click", function imageClick() {
            console.log("Sticker clicked");
            live_video = document.getElementById("live-video");

            // Remove previous stickers.
            removeStickers(live_video);
        
            // Create new image and append to div container.
            var sticker = createSticker(img.src);
            live_video.appendChild(sticker);
        });
    });
})();
