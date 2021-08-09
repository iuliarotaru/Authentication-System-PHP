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
