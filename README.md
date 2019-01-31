# Simple Calendar #

### Basic information ###
* Demo: http://ec2-52-15-202-27.us-east-2.compute.amazonaws.com/~JingqiFan/module5/calendar.php
* Two existing login credentials:  
Username: yoyoyo --- Password: test123  
Username: admin  --- Password: test123  

### Basic navigation ###
New users can sign up for a new account and then log in with their credentials to access their page.  
Once logged in, the calendar will grant user access to add event feature in the top nav bar. User can  
edit and delete event by clicking on each event blocks within the date grid.  

### Creative portion ###
Three additional features are added:  

* A tagging feature is added. Users can select event type when they add or edit event, the  
corresponding event will be colored differently depending on the tag and colors will update  
dynamically when tag is changed.  

* A sharing feature is availiable when user X want to share their event with registered user Y. The  
function can be accessed with the editing event feature. Shared event will have a "Shared by X" title  
appended to an event's existing name in the calendar view of user Y to distinguish from user Y's  
other events.  

* The site is made responsive by using Bootstrap 4.

### Code ###
JS is used to process user interactions at the web browser, without refreshing after the initial web  
page load. The application utilize AJAX to run server-side scripts that query MySQL database to save  
and retrieve information, including user accounts and events.  

Code in calendar.js from line 131 to line 136 is adapted from a stackoverflow post: https://stackoverflow.com/questions/1531093/how-do-i-get-the-current-date-in-javascript

### Author Info ###
Code by Jingqi Fan