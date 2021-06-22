// ----------------------------------------------------------
// Toggle home menu
function toggleHomeMenu() {
  // Nav menu
  let links = document.querySelector("#nav_links");
  let close_icon = document.querySelector(".close");
  let hamburger_icon = document.querySelector(".hamburger");
  // Home menu
  let left_links = document.querySelector(".admin_left");
  let right_button = document.querySelector(".admin_right");
  if (
    !left_links.classList.contains("hide_home_links") &&
    !right_button.classList.contains("hide_home_links")
  ) {
    left_links.classList.add("hide_home_links");
    right_button.classList.add("hide_home_links");
  } else {
    left_links.classList.remove("hide_home_links");
    right_button.classList.remove("hide_home_links");
    links.classList.add("hide_nav_links");
    hamburger_icon.style.display = "block";
    if (close_icon) {
      close_icon.style.display = "none";
    }
  }
}
// ----------------------------------------------------------
// Toggle hamburger menu
function toggleHamburger() {
  // Nav menu
  let links = document.querySelector("#nav_links");
  let close_icon = document.querySelector(".close");
  let hamburger_icon = document.querySelector(".hamburger");
  // Home menu
  let left_links = document.querySelector(".admin_left");
  let right_button = document.querySelector(".admin_right");

  if (!links.classList.contains("hide_nav_links")) {
    links.classList.add("hide_nav_links");
    hamburger_icon.style.display = "block";
    if (close_icon) {
      close_icon.style.display = "none";
    }
  } else {
    links.classList.remove("hide_nav_links");
    hamburger_icon.style.display = "none";
    if (close_icon) {
      close_icon.style.display = "block";
    }
    left_links.classList.add("hide_home_links");
    right_button.classList.add("hide_home_links");
  }
}
// ----------------------------------------------------------
// Toggle text see more
function toggleText() {
  let parent_element = event.target.parentElement;
  let points = parent_element.querySelector("#points");
  let show_more_text = parent_element.querySelector("#moreText");
  let button_text = parent_element.querySelector("#textButton");

  if (points.style.display === "none") {
    show_more_text.style.display = "none";
    points.style.display = "inline";
    button_text.innerHTML = "Read more";
  } else {
    show_more_text.style.display = "inline";
    points.style.display = "none";
    button_text.innerHTML = "Read less";
  }
}
// ----------------------------------------------------------
// Like a post with AJAX
async function like_post(post_id) {
  // console.log(event.target);
  let like_button = event.target;
  let parentElement = like_button.parentNode;
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
    `<button id="dislike-button" class="icon icon-liked" onclick="dislike_post('${post_id}')"></button>`
  );
  let likes = document.querySelector("#likes").textContent;
  let new_likes = parseInt(likes) + 1;
  document.querySelector("#likes").innerHTML = new_likes;
}
// ----------------------------------------------------------
// Dislike a post with AJAX
async function dislike_post(post_id) {
  console.log(event.target);
  let dislike_button = event.target;
  let parentElement = dislike_button.parentNode;
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
    `<button id="like-button" class="icon icon-like" onclick="like_post('${post_id}')"></button>`
  );
  let likes = document.querySelector("#likes").textContent;
  let new_likes = parseInt(likes) - 1;
  document.querySelector("#likes").innerHTML = new_likes;
}
// ----------------------------------------------------------
// Block user with AJAX
async function block_user(user_id) {
  let div_user = event.target;
  const button_text = div_user.innerText;
  div_user.innerText = "Blocking....";
  let connection = await fetch(`/users/block/${user_id}`, {
    method: "POST",
  });
  let response = await connection.text();
  if (!connection.ok) {
    alert(response);
    div_user.innerText = button_text;
    return;
  }
  div_user.innerText = "Blocked";
  div_user.disabled = true;
}

// ----------------------------------------------------------
// Signup form AJAX
const signup_form = document.getElementById("signup_form");
if (signup_form) {
  signup_form.addEventListener("submit", async function (event) {
    event.preventDefault();
    // Validate form
    if (validate()) {
      let connection = await fetch("/signup", {
        method: "POST",
        body: new FormData(signup_form),
      });
      if (!connection.ok) {
        console.log(connection.ok);
        let response = await connection.text();
        console.log(response);
        signup_form.insertAdjacentHTML("beforeend", response);
        return;
      } else {
        signup_form.remove();
        const signup_title = document.querySelector(".signup_title");
        console.log(signup_title);
        // let divElem = document.createElement("div");
        // divElem.innerHTML =
        //   "<div> A verification link has been sent to your email </div>";
        // document.body.appendChild(divElem);
        signup_title.insertAdjacentHTML(
          "afterend",
          '<span class="verification_text"> A verification link has been sent to your email </span> <div class="verification_illustration"> </div>'
        );
      }
    }
  });
}
// ----------------------------------------------------------
// Update image AJAX
async function updatePicture() {
  document.querySelectorAll(".upload_image_messages").forEach((element) => {
    element.parentNode.removeChild(element);
  });
  const img = event.target.files;
  if (img.length == 0) {
    event.target.insertAdjacentHTML(
      "afterend",
      "<div class='upload_image_messages'> Please insert a picture </div>"
    );
  } else {
    const valid_extensions = ["png", "jpg", "jpeg", "gif"];
    const extension = img[0].type.split("/").pop();
    if (!valid_extensions.includes(extension)) {
      document
        .querySelector("#update_image")
        .insertAdjacentHTML(
          "beforebegin",
          "<div class='upload_image_messages'> Please upload a valid image </div>"
        );
    } else if (img[0].size > 2000000) {
      document
        .querySelector("#update_image")
        .insertAdjacentHTML(
          "beforebegin",
          "<div class='upload_image_messages'> Image file exceeds 2MB </div>"
        );
    } else {
      const file = document.querySelector("input[type=file]").files[0];
      const form_data = new FormData();
      form_data.append("my_updated_image", file);
      let connection = await fetch("/update-image", {
        method: "POST",
        body: form_data,
      });
      let response = await connection.text();
      if (!connection.ok) {
        console.log(response);
      } else {
        showFile();
        document
          .querySelector("#update_image")
          .insertAdjacentHTML(
            "beforebegin",
            "<div class='upload_image_messages'> Your profile image has been successfully updated </div>"
          );
      }
    }
  }
}
// ----------------------------------------------------------
// Update form AJAX
const update_form = document.getElementById("update_form");
if (update_form) {
  update_form.addEventListener("submit", async function (event) {
    event.preventDefault();
    const update_message = document.getElementById("update_message");
    if (update_message) {
      update_message.parentNode.removeChild(update_message);
    }
    // Validate form
    if (validate()) {
      let connection = await fetch("/update-profile", {
        method: "POST",
        body: new FormData(update_form),
      });
      console.log(connection);
      if (!connection.ok) {
        console.log(connection.ok);
        let response = await connection.text();
        console.log(response);
        update_form.insertAdjacentHTML("beforeend", response);
        return;
      } else {
        update_form.insertAdjacentHTML(
          "beforeend",
          "<div id='update_message'> Your profile has been successfully updated </div>"
        );
      }
    }
  });
}
// ----------------------------------------------------------
// Search for a user
let search_timer; // used to stop the search timer
function search() {
  const noSearchResults = document.querySelector("#no_results");
  if (search_timer) {
    clearTimeout(search_timer);
  }

  if (event.target.value.length >= 2) {
    search_timer = setTimeout(async function () {
      let connection = await fetch("/search", {
        method: "POST",
        body: new FormData(document.querySelector("#form_search_for")),
      });

      if (!connection.ok) {
        console.log(connection.ok);
        let response = await connection.text();
        console.log(response);
        // document
        //   .querySelector("#form_search_for")
        //   .insertAdjacentHTML("beforeend", response);
      } else {
        let users = await connection.json();
        console.log(users);
        //hide every user
        document.querySelectorAll("[data-id]").forEach((element) => {
          element.classList.add("hidden");
        });
        if (users.length != 0) {
          if (noSearchResults) {
            noSearchResults.parentNode.removeChild(noSearchResults);
          }
          //show only users that match the search
          users.forEach((user) => {
            document
              .querySelector(`[data-id='${user.uuid}']`)
              .classList.remove("hidden");
          });
        } else {
          if (!noSearchResults) {
            document
              .querySelector("#form_search_for")
              .insertAdjacentHTML(
                "beforeend",
                "<div id='no_results'> No results matching your search </div>"
              );
          }
        }
      }
    }, 500);
  } else {
    //remove hidden
    document.querySelectorAll("[data-id]").forEach((element) => {
      element.classList.remove("hidden");
    });
    if (noSearchResults) {
      noSearchResults.parentNode.removeChild(noSearchResults);
    }
  }
}

// ----------------------------------------------------------
// Frontend validation
function validate() {
  const form = event.target;
  console.log(form);

  //Clear errors

  form.querySelectorAll("[data-validate]").forEach((element) => {
    element.classList.remove("error");
  });
  form.querySelectorAll(".image_error").forEach((element) => {
    element.parentNode.removeChild(element);
  });

  //Then check for errors
  let min;
  let max;
  form.querySelectorAll("[data-validate]").forEach((element) => {
    switch (element.getAttribute("data-validate")) {
      case "str":
        min = element.getAttribute("data-min");
        max = element.getAttribute("data-max");
        let total_char = element.value.length;
        if (total_char < min || total_char > max) {
          element.classList.add("error");
        }
        break;
      case "int":
        max = parseInt(element.getAttribute("data-max"));
        min = parseInt(element.getAttribute("data-min"));
        let phone = parseInt(element.value); //returns NaN if empty
        if (!phone || phone < min || phone > max) {
          //why is the input showing error only with !phone
          element.classList.add("error");
        }
        break;
      case "email":
        const re = /^[a-z0-9]+[\._]?[a-z0-9]+[@]\w+[.]\w{2,3}$/;
        if (!re.test(element.value.toLowerCase())) {
          element.classList.add("error");
        }
        break;
      case "confirm-p":
        const password1 = one("#password1").value;
        const password2 = one("#password2").value;
        if (!password2 || password1 != password2) {
          element.classList.add("error");
        }
        break;
      case "img":
        const img = element.files;
        if (img.length == 0) {
          element.parentNode.insertAdjacentHTML(
            "afterend",
            "<div class='image_error'> Please insert a picture </div>"
          );
        } else {
          const valid_extensions = ["png", "jpg", "jpeg", "gif"];
          const extension = img[0].type.split("/").pop();
          if (!valid_extensions.includes(extension)) {
            element.parentNode.insertAdjacentHTML(
              "afterend",
              "<div class='image_error'> Please upload a valid image </div>"
            );
          }
          if (img[0].size > 2000000) {
            element.parentNode.insertAdjacentHTML(
              "afterend",
              "<div class='image_error'> Image file exceeds 2MB </div>"
            );
          }
        }
    }
  });
  return form.querySelector(".error") ? false : true;
}

function clear_error() {
  event.target.classList.remove("error");
}
function triggerClick() {
  document.querySelector("#my_profile_image").click();
}
function showFile() {
  const file = document.querySelector("input[type=file]").files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function () {
      document
        .querySelector("#image_placeholder")
        .setAttribute("src", reader.result);
    };
    reader.readAsDataURL(file);
  }
}

//Library
function one(selector) {
  return document.querySelector(selector);
}
function all(selector) {
  return document.querySelectorAll(selector);
}
