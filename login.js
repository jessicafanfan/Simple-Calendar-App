
async function handleSubmit (event) {
  event.preventDefault()

  const form = event.currentTarget
  const body = {
    username: form.elements.username.value, 
    password: form.elements.password.value
  }

  const response = await fetch('login_ajax.php', {
    method: 'POST',
    body: JSON.stringify(body),
    headers: {
      'Content-Type': 'application/json'
    }
  })

  const result = await response.json()

  if (!result.success) {
    alert(result.message);

    return
  }
  savedToken = result.token;
  document.body.dataset.username = result.user;  
  window.updateBindableElements()

  updateCalendar();
  // $("#message").html("<p class='error'>Logged in successfully!</p>");
}

const loginForm = document.getElementById('login-wrapper')

if (loginForm) {
  loginForm.addEventListener('submit', handleSubmit)
}
