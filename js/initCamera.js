(function initCamera() {
  var btnCapture = document.getElementById("btn_captures");
  var canvas = document.getElementById("canvas");
  var photo = document.getElementById("photo");
  var context = canvas.getContext("2d");
  var video = document.getElementById("video");
  var height;
  var width;

  /**
   * Take a picture, draw it in canvas and convert it
   * to data URI (PNG) to show on the HTML page.
   */
  function takepicture(vid, width, height) {
    canvas.width = width;
    canvas.height = height;

    context.drawImage(vid, 0, 0, width, height);
    var data = canvas.toDataURL("image/png");
    photo.setAttribute("src", data);

    // Set img data as input in form.
    var imgInput = document.getElementById("imgInput");
    imgInput.setAttribute("value", data);
  }

  function placepicture(img, width, height) {
    canvas.width = width;
    canvas.height = height;

    context.drawImage(img, 0, 0, width, height);
    var data = canvas.toDataURL("image/png");
    photo.setAttribute("src", data);

    // Set img data as input in form.
    var imgInput = document.getElementById("imgInput");
    imgInput.setAttribute("value", data);
  }

  function addFileForm() {
    var fileInput = document.createElement("input");
    var videoDiv = document.getElementById("live-video");

    fileInput.setAttribute("type", "file");
    fileInput.setAttribute("id", "fileInput");
    fileInput.setAttribute("name", "fileInput");

    videoDiv.prepend(fileInput);
    return fileInput;
  }

  function StickerListener() {
    var stickers = document.querySelectorAll("[data-role=sticker]");

    stickers.forEach(function addListener(img) {
      img.addEventListener("click", function imageClick() {
        var stickerInput = document.getElementById("stickerInput");
        stickerInput.setAttribute("value", img.getAttribute("data-name"));

        var btnCapture = document.getElementById("btn_captures");
        btnCapture.disabled = false;
      });
    });
  }

  if (hasGetUserMedia() == true) {
    var constraints = { video: true, audio: false };

    navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
      video.srcObject = stream;
      video.addEventListener("loadedmetadata", function loadVData() {
        height = this.videoHeight;
        width = this.videoWidth;
      });
    });
    btnCapture.addEventListener(
      "click",
      function (ev) {
        takepicture(video, width, height);
      },
      false,
    );
  } else {
    var fileInput = addFileForm();

    btnCapture.innerHTML = "Upload image";
    video.remove();

    StickerListener();

    btnCapture.addEventListener(
      "click",
      function () {
        if (fileInput.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            var img = new Image();
            img.onload = function () {
              placepicture(img, img.width, img.height);
            };
            // load image
            img.setAttribute("src", e.target.result);
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      },
      false,
    );
  }
})();
