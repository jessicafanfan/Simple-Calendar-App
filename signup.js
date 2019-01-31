function Signup(event){
  $("#signup-dialog").dialog();
}

document.getElementById('show-sign-upp').addEventListener("click",Signup);
document.getElementById("signup-button").addEventListener("click", onSignup, false);

function onSignup() {
  const pathToPhpFile = 'signup_ajax.php';
  const data = { username: $('#signup-username').val(),
  password: $('#signup-password').val(),
  password2: $('#signup-password-confirm').val() };
  console.log(data);
    $.ajax(
      {
          url: pathToPhpFile ,
          type:'POST',
          dataType: 'text',
          data: data,
          success: function(response)
          {
          
            const result = JSON.parse(response);
            
            if (result.success) {
              $('#signup-dialog').dialog('close');
            alert("Signed up successfully")
            document.body.dataset.username = 'guest'
            updateCalendar()
          }
            else {  
            alert(result.message);
          }}
      })
  }
