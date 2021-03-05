function like(gallery_id) {
  var likeBtn = document.getElementById(`like_${gallery_id}`);
  var likesN = document.getElementById(`likes_${gallery_id}`);

  var url = "like.php";
  var requestBody = `gallery_id=${gallery_id}&action=like`;
  var fetchInit = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: requestBody,
  };
  fetch("like.php", fetchInit)
    .then((res) => res.text())
    .then((text) => {
      if (text.length != 0) {
        likesN.innerHTML = text;
        likeBtn.className = "bi bi-heart-fill";
        likeBtn.setAttribute("onclick", `unlike(${gallery_id})`);
      }
    });
}

function unlike(gallery_id) {
  var likeBtn = document.getElementById(`like_${gallery_id}`);
  var likesN = document.getElementById(`likes_${gallery_id}`);

  var url = "like.php";
  var requestBody = `gallery_id=${gallery_id}&action=unlike`;
  var fetchInit = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: requestBody,
  };
  fetch("like.php", fetchInit).then((res) =>
    res.text().then((text) => {
      if (text.length != 0) {
        likesN.innerHTML = text;
        likeBtn.className = "bi bi-suit-heart";
        likeBtn.setAttribute("onclick", `like(${gallery_id})`);
      }
    }),
  );
}
