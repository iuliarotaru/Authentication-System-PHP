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
        let response = await connection.text();
        document
          .querySelector("#form_search_for")
          .insertAdjacentHTML("beforeend", response);
      } else {
        let users = await connection.json();
        //hide every user
        document.querySelectorAll("[data-id]").forEach((element) => {
          element.classList.add("hidden");
        });
        if (users.length != 0) {
          if (noSearchResults) {
            noSearchResults.remove();
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
      noSearchResults.remove();
    }
  }
}
