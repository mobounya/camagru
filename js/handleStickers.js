(function placeStickers() {
    var stickers = document.querySelectorAll("[data-role=sticker]");
    var canvas = document.getElementById('canvas')
    var context = canvas.getContext('2d');

    stickers.forEach(function addListener(img) {
        img.addEventListener("click", function imageClick() {
            console.log("Clicked");
            base_image = new Image();
            base_image.src = 'chefhat.png';
            context.drawImage(base_image, 150, 150);
        });
    });
})();
