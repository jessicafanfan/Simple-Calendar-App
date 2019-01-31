<?php
ini_set("session.cookie_httponly", 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Simple Calendar</title>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="stylesheet" href="calendar.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
  <script src="http://classes.engineering.wustl.edu/cse330/content/calendar.min.js"></script>
  <script src="calendar.js"></script>
  <script>
    window.updateBindableElements = function() {
      const username = document.body.dataset.username
      
      if (!username) return
      
      const bindableElements = Array.from(document.querySelectorAll('[data-bind="username"]')) || []
      
      bindableElements.forEach(element => element.textContent = username)
    }

    $('body').height(document.documentElement.clientHeight);
    let savedToken = "";
  </script>
  
</head>

<body data-username="<?php if(isset($_SESSION['user'])) echo $_SESSION['user']; else echo 'guest'; ?>">
  <nav>
    <p class="today"></p>
    
    <button id="prev-month-btn" class="btn btn-light btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
    <button id="next-month-btn" class="btn btn-light btn-sm"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
    <div id="current-month"></div>
    <div id="current-year"></div>

    <button id='show-sign-upp' class="btn btn-secondary mb-2 mr-sm-2 btn-sm guest-only">Sign up</button>

    <form class="form-inline guest-only" id="login-wrapper">
      <label class="sr-only" for="login-username">Username</label>
      <input id="login-username" type="text" name="username" class="form-control mb-2 mr-sm-2 form-control-sm" placeholder="Username" />
      
      <label class="sr-only" for="login-password">Password</label>
      <input id="login-password" name="password" type="password" class="form-control mb-2 mr-sm-2 form-control-sm" placeholder="Password" />
      
      <input type="submit" class="btn btn-primary mb-2 mr-sm-2 btn-sm" value="Login" />
    </form>

    <div id="loggedin-wrapper" class="authenticated-only">
    <button class="welcome-msg btn btn-light btn-sm" disabled>Welcome, <span data-bind="username"></span>!</button>
      <button class="btn btn-primary btn-sm" id='addEvent'>Add Event</button>
      <button class="btn btn-secondary btn-sm" id='logout'>Log out</button>
    </div>
    
  </nav>
  
  
  <div id="signup-dialog" style="display: none; background: #e1e1e1; padding: 20px; border: 2px solid #888">
    
    <table style="height: 100px;">
      
      <tr>
        
        <td class="dialog">Username:</td>
        <td>
          <input id="signup-username" type="text" name="username" placeholder="Username">
        </td>
        
      </tr>
      
      <tr>
        
        <td>Password:</td>
        <td>
          <input id="signup-password" type="password" name="password" placeholder="Password" />
        </td>
        
      </tr>
      
      <tr>
        
        <td>Confirm Password:</td>
        <td>
          <input id="signup-password-confirm" type="password" name="password" placeholder="Password" />
        </td>
        
      </tr>
      
    </table>
    
    <input id="signup-button" type="submit" value="Signup!">
    
  </div>
  
  <div id="addEvent-dialog" style="display: none; background: #e1e1e1; padding: 20px; border: 2px solid #888">
    
    <table style="height: 100px;">
      <tr>
        <td>Name:</td>
        <td>
          <input id="event-name" type="text" name="date" placeholder="Enter Event Name">
          
        </td>
      </tr>
      <tr>
        <td>Event Type:</td>
        <td>
          <select id="event-type">
            <option value="Home">Home</option>
            <option value="Work">Work</option>
            <option value="School">School</option>
            <option value="Extra">Extra</option>
            <option value="Important">Important</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Date:</td>
        <td>
          <input id="event-date" type="date" name="date" >
        </td>
      </tr>
      <tr>
        <td>Start Time:</td>
        <td>
          <input id="event-start-time" type="time" name="start-time" />
        </td>
      </tr>
      <tr>
        <td>End Time:</td>
        <td>
          <input id="event-end-time" type="time" name="end-time"/>
        </td>
      </tr>
    </table>
    
    <input id="addEvent-button" type="submit" value="Add Event">
    
  </div>
  
  <div id="editEvent-dialog" style="display: none; background: #e1e1e1; padding: 20px; border: 2px solid #888">
    
    <table style="height: 100px;">
      <tr>
        <td>Name:</td>
        <td>
          <input id="edit-event-name" type="text" name="date" placeholder="Enter Event Name">
          <input id="edit-event-id" type="hidden" value="" />
          <input id="edit-event-username" type="hidden" value="<?=$_SESSION['u_id']?>" />
        </td>
      </tr>
      <tr>
        <td>Event Type:</td>
        <td>
          <select id="edit-event-type">
            <option value="Home">Home</option>
            <option value="Work">Work</option>
            <option value="School">School</option>
            <option value="Extra">Extra</option>
            <option value="Important">Important</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Date:</td>
        <td>
          <input id="edit-event-date" type="date" name="date">
        </td>
      </tr>
      <tr>
        <td>Start Time:</td>
        <td>
          <input id="edit-event-start-time" type="time" name="start-time" />
        </td>
      </tr>
      <tr>
        <td>End Time:</td>
        <td>
          <input id="edit-event-end-time" type="time" name="end-time" />
        </td>
      </tr>
      <tr>
        <td>Share event with another user</td>
        <td>
          <input id="group-event-username" type="text" name="group-event" placeholder="Username" />
        </td>
      </tr>
    </table>
   <!-- <input type="hidden" id="token" value="<?php echo $_SESSION['token'];?>" />-->
    <input id="saveChanges-button" type="submit" value="Save Changes"/>
    <input id="delete-button" type="submit" value="delete" onclick="onDeleteEvent();"/>
  </div>
  
  <div id="calendar-container"></div>

  <script src="login.js"></script>
  <script src="signup.js"></script>
  <script src="ajax.js"></script>

  <script src="addEvent.js"></script>
  <script src="editEvent.js"></script>
  <script src="deleteEvent.js"></script>
 
</body>
</html>