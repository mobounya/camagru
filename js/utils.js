function hasGetUserMedia() {
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
    return true;
  else return false;
}

// Create a new sticker
function createSticker(src) {
  var sticker = document.createElement("img");

  sticker.src = src;
  sticker.style.position = "absolute";
  sticker.style.top = "45px";
  sticker.style.left = "185px";
  // sticker.style.transform = "translate(-50%)";

  return sticker;
}

function removeStickers(parent) {
  var old_stickers = parent.querySelectorAll("img");

  old_stickers.forEach((elem) => elem.remove());
}

/**
 * @param  {} object
 * Print all attributes of an object and their value
 */
function debugObject(object) {
  for (let key in object) {
    console.log(key, object[key]);
  }
}

function initInputPasswords(selector) {
  var components = document.querySelectorAll(selector);

  components.forEach(function init(component) {
    var passwordInput = component.querySelector("input");
    var div = component.querySelector("div");
    var toggle = div.querySelector("input");

    toggle.addEventListener("click", createShowPassword(passwordInput));
  });
}

function createShowPassword(element) {
  return function showPassword() {
    if (element.getAttribute("type") == "password")
      element.setAttribute("type", "text");
    else element.setAttribute("type", "password");
  };
}

initInputPasswords("[data-role=input-password]");
