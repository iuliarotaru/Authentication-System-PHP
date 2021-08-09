// ----------------------------------------------------------
// Block user with AJAX
async function blockUser(user_id) {
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
