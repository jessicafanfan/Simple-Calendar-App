


//document.getElementById("login-button").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click

// function signupAjax(event) {
//     const username = document.getElementById("signup-username").value; // Get the username from the form
//     const password = document.getElementById("signup-password").value; // Get the password from the form
//     const passwordConfirm = document.getElementById("signup-password-confirm").value; // Get the password from the form
//     // Make a URL-encoded string for passing POST data:
//     const data = { 'username': username, 'password': password, 'passwordConfirm': passwordConfirm };

//     fetch("signup_ajax.php", {
//             method: 'POST',
//             body: JSON.stringify(data),
//             headers: { 'content-type': 'application/json' }
//         })
//         .then(response => response.json())
//         .then(data => console.log(data.success ? "You are signed up!" : `You were not signed up ${data.message}`));

//     if(data.success) {
//       $('#signup-dialog').dialog('close');

//       //$('#login-wrapper').css('display', 'none');
//       document.getElementById('login-wrapper').style.display = "none";
//       //$('#loggedin-wrapper').css('display', 'block');
//       document.getElementById('loggedin-wrapper').style.display = "block";
//       $('#loggedin-wrapper').html('Welcome, ' + result.user.user_uid + '!');
//       $('#logout').css('display', 'block');

//     } else {


//       alert(data.message);
//     }
// }

//document.getElementById("signup-button").addEventListener("click", signupAjax, false);


async function logout (event) {
  const response = await fetch('logout_ajax.php', {
    method: 'POST',
    headers: { 'content-type': 'application/json' }
  })
  const results = await response.json()

  if (!results.success) {
    console.error(results)
    return
  }
  
  alert("Logged out successfully")
  document.body.dataset.username = 'guest'
  updateCalendar()
}

document.getElementById("logout").addEventListener("click", logout, false);

function addEventAjax(event){
  const name = document.getElementById("event-name").value;
  const event_type = document.getElementById("event-type").value;
  const event_date = document.getElementById("event-date").value;
  const start_time = document.getElementById("event-start-time").value;
  const end_time = document.getElementById("event-end-time").value;
  
  const data = { 'name': name, 'event_type': event_type, 'event_date': event_date, 'start_time': start_time, 'end_time': end_time };
  fetch("addEvent_ajax.php",{
    method:'POST',
    body: JSON.stringify(data),
    headers: { 'content-type': 'application/json'}
  })
  .then(response => response.json())
  .then(data => console.log(data.success ? "Event Added!" : `Event not added ${data.message}`));
}

//document.getElementById("addEvent-button").addEventListener("click", addEventAjax, false);

// function onShareEvents(){
//     const usernameToShareWith = document.getElementById("uid_share").value;
//     const loggedInUser = $_SESSION('user');


// }