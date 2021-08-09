// ----------------------------------------------------------
// Like a post with AJAX
async function likePost(post_id) {
  let like_button = event.target;
  let parentElement = like_button.parentNode;
  let current_post = document.getElementById(post_id);
  let connection = await fetch(`/posts/${post_id}/1`, {
    method: "POST",
  });
  let response = await connection.text();
  if (!connection.ok) {
    console.log(response);
  }
  parentElement.removeChild(like_button);
  parentElement.insertAdjacentHTML(
    "beforeend",
    `<button id="dislike-button" class="icon icon-liked" onclick="dislikePost('${post_id}')"></button>`
  );
  let likes = current_post.querySelector("#likes").textContent;
  console.log(likes);
  let new_likes = parseInt(likes) + 1;
  current_post.querySelector("#likes").innerHTML = new_likes;
}
// ----------------------------------------------------------
// Dislike a post with AJAX
async function dislikePost(post_id) {
  let dislike_button = event.target;
  let parentElement = dislike_button.parentNode;
  let current_post = document.getElementById(post_id);
  let connection = await fetch(`/posts/${post_id}/0`, {
    method: "POST",
  });
  let response = await connection.text();
  if (!connection.ok) {
    console.log(response);
  }
  parentElement.removeChild(dislike_button);
  parentElement.insertAdjacentHTML(
    "beforeend",
    `<button id="like-button" class="icon icon-like" onclick="likePost('${post_id}')"></button>`
  );
  let likes = current_post.querySelector("#likes").textContent;
  let new_likes = parseInt(likes) - 1;
  current_post.querySelector("#likes").innerHTML = new_likes;
}
