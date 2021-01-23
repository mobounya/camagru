(function initCamera() {
    var video = document.getElementById('video');
    // var canvas = document.getElementById('canvas');
    // var context = canvas.getContext('2d');
    
    if (hasGetUserMedia() == true) {
        var constraints = { video: true };

        navigator.mediaDevices.getUserMedia(constraints)
            .then((stream) => {
                video.srcObject = stream;
            });
    }

    // video.addEventListener('loadedmetadata', function () {
    //     canvas.width = video.videoWidth;
    //     canvas.height = video.videoHeight;
    // });

    // video.addEventListener('play', function () {
    //     var $this = this; //cache
    //     (function loop() {
    //         if (!$this.paused && !$this.ended) {
    //             context.drawImage($this, 0, 0);
    //             setTimeout(loop, 1000 / 30); // drawing at 30fps
    //         }
    //     })();
    // });
})();