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
        let divElem = document.createElement("div");
        divElem.innerHTML =
          "<div> A verification link has been sent to your email </div>";
        document.body.appendChild(divElem);
      }
    }
  });
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
// Frontend validation
function validate() {
  const form = event.target;

  //Clear errors

  all("[data-validate]").forEach((element) => {
    element.classList.remove("error");
  });

  //Then check for errors
  let min;
  let max;
  all("[data-validate]").forEach((element) => {
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
          element.insertAdjacentHTML(
            "afterend",
            "<div> ADAUGA O POZA IN MORTII TAI </div>"
          );
        }
    }
  });
  return form.querySelector(".error") ? false : true;
}

function clear_error() {
  event.target.classList.remove("error");
}

function showFile() {
  console.log(event.target);
  let thumbnail = new Image();
  thumbnail.width = "50";
  thumbnail.height = "50";
  event.target.insertAdjacentElement("afterend", thumbnail);
  var file = document.querySelector("input[type=file]").files[0];
  var reader = new FileReader();
  reader.onload = function () {
    // console.log(event.target)
    // demoImage.src = reader.result;
    thumbnail.src = reader.result;
  };
  reader.readAsDataURL(file);
  // console.log(file)
}

//Library
function one(selector) {
  return document.querySelector(selector);
}
function all(selector) {
  return document.querySelectorAll(selector);
}
