(function initCamera() {
    var btnCapture = document.getElementById('btn_captures');
    var canvas = document.getElementById('canvas');
    var photo = document.getElementById('photo');
    var context = canvas.getContext("2d");
    var video = document.getElementById('video');
    var height;
    var width;

    function addImgForm(data)
    {
        // Get the form that will append our inputs into.
        form = document.getElementById('imgForm');
        input = document.createElement("INPUT");
        saveBtn = document.createElement("button");

        // Fill INPUT with our img data.
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'img');
        input.setAttribute('value', data);

        // Our save button (remove button).
        saveBtn.setAttribute('type', 'submit');
        saveBtn.innerHTML = "Save";

        form.appendChild(input);
        form.appendChild(saveBtn);
    }
    /**
     * Take a picture, draw it in canvas and convert it
     * to data URI (PNG) to show on the HTML page.
     */
    function takepicture(vid)
    {
        console.log("taking picture...");
        canvas.width = width;
        canvas.height = height;

        context.drawImage(vid, 0, 0, width, height);
        var data = canvas.toDataURL('image/jpeg');
        photo.setAttribute('src', data);

        // Set img data as input in form.
        var imgInput = document.getElementById("imgInput");
        imgInput.setAttribute("value", data);
    }

    if (hasGetUserMedia() == true) {
        var constraints = { video: true, audio: false};

        navigator.mediaDevices.getUserMedia(constraints)
            .then((stream) => {
                video.srcObject = stream;
                video.addEventListener("loadedmetadata", function loadVData() {
                    height = this.videoHeight;
                    width = this.videoWidth;
                })
            });
        btnCapture.addEventListener("click", function(ev)
        {
            takepicture(video);
            ev.preventDefault();
        }, false);
    }
})();



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