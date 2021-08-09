setTimeout(function testMe(name, last_name) {
  console.log(name, last_name);
}, 5000);

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
        let response = await connection.text();
        signup_form.insertAdjacentHTML("beforeend", response);
        return;
      } else {
        signup_form.remove();
        const signup_title = document.querySelector(".signup_title");
        signup_title.insertAdjacentHTML(
          "afterend",
          '<span class="verification_text"> A verification link has been sent to your email </span> <div class="verification_illustration"> </div>'
        );
      }
    }
  });
}
// ----------------------------------------------------------
// Update picture AJAX
async function updatePicture() {
  document.querySelectorAll(".upload_image_messages").forEach((element) => {
    element.remove();
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
console.log(update_form);
if (update_form) {
  update_form.addEventListener("submit", async function (event) {
    console.log("iulia");
    event.preventDefault();
    const update_message = document.getElementById("update_message");
    if (update_message) {
      update_message.remove();
    }
    // Validate form
    if (validate()) {
      let connection = await fetch("/update-profile", {
        method: "POST",
        body: new FormData(update_form),
      });
      if (!connection.ok) {
        let response = await connection.text();
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
// Frontend validation
function validate() {
  const form = event.target;
  //Clear errors
  form.querySelectorAll("[data-validate]").forEach((element) => {
    element.classList.remove("error");
  });
  form.querySelectorAll(".image_error").forEach((element) => {
    element.remove();
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
        let phone = parseInt(element.value);
        if (!phone || phone < min || phone > max) {
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
function clearError() {
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
