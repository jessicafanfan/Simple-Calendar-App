let currentMonth;

const indexToMonth = {
  0: "January",
  1: "February",
  2: "March",
  3: "April",
  4: "May",
  5: "June",
  6: "July",
  7: "August",
  8: "September",
  9: "October",
  10: "November",
  11: "December"
}

async function updateCalendar () {

  const events = await fetchEvents();
  const calendarContainer = document.getElementById('calendar-container');


  console.log(events);


  document.getElementById('current-month').textContent = indexToMonth[currentMonth.month]
  document.getElementById('current-year').textContent = currentMonth.year

  let weekRows = "";

  currentMonth.getWeeks().forEach(function (week) {

    let days = week.getDates();

    weekRows += "<tr>";

    days.forEach(function (day) {

      const dayClass = day.getMonth() === currentMonth.month ? 'active' : 'inactive';
      const dayNumber = day.getDate();
      const monthnew= day.getMonth()+1;
      const fullDate = day.getFullYear() + '-' + monthnew + '-' + day.getDate();

      weekRows += `<td  class="${dayClass}">${dayNumber}<div class="event">`;
      if (events) {
      for(let i = 0; i < events.length; i++) {
        // console.log(fullDate, events[i].event_date);

        if(fullDate === events[i].event_date) {
          let colorClass = "";
          if (events[i].event_type == "home"){
            colorClass="card text-white bg-primary mb-1";
          }
          else if (events[i].event_type == "Work"){
            colorClass="card text-white bg-secondary mb-1";
          }
          else if (events[i].event_type == "Important"){
            colorClass="card text-white bg-danger mb-1";
          }
          else if (events[i].event_type == "School"){
            colorClass="card text-white bg-success mb-1";
          }
          else {
            colorClass="card text-white bg-warning mb-1";
          }
          
          weekRows += '<a class="'+colorClass+'" style="display:block" href="#" onclick="editEvent('+events[i].event_id+')">'+events[i].event_name;+'</a>';

        }

      }
    }

      weekRows += '</div>';

    })
    
    weekRows += "</tr>";

  })

  const calendarStructure = `
    <table class='table table-bordered table-striped table-sm calendar'>
      <thead class='head'>
        <tr>
          <th><span class="full">Sunday</span><span class="abbr">S</span></th>
          <th><span class="full">Monday</span><span class="abbr">M</span></th>
          <th><span class="full">Tuesday</span><span class="abbr">T</span></th>
          <th><span class="full">Wednesday</span><span class="abbr">W</span></th>
          <th><span class="full">Thursday</span><span class="abbr">T</span></th>
          <th><span class="full">Friday</span><span class="abbr">F</span></th>
          <th><span class="full">Saturday</span><span class="abbr">S</span></th>
        </tr>
      </thead>
      <tbody>
        ${weekRows}
      </tbody>
    </table>`
  calendarContainer.innerHTML = calendarStructure;
}






function initialize () {
  window.updateBindableElements()

  //Change the month when the "next" button is pressed
  document.getElementById("next-month-btn").addEventListener("click", function (event) {
    currentMonth = currentMonth.nextMonth();
    updateCalendar();// re-render the calendar in HTML
    console.log(`The new month is ${currentMonth.month} ${currentMonth.year}`);
  });

  // Change the month when the "previous" button is pressed
  document.getElementById("prev-month-btn").addEventListener("click", function(event) {
    currentMonth = currentMonth.prevMonth();
    updateCalendar(); // re-render the calendar in HTML
    console.log(`The new month is ${currentMonth.month} ${currentMonth.year}`);
  });

  const today = new Date()
  const _year = today.getFullYear()
  const _month = today.getMonth()
  const _day = today.getDate()

  //below six lines of code is adapted from https://stackoverflow.com/questions/1531093/how-do-i-get-the-current-date-in-javascript
  let weekday = new Array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
  let dayOfWeek = weekday[today.getDay()];
  let domEnder = function() { let a = today; if (/1/.test(parseInt((a + "").charAt(0)))) return "th"; a = parseInt((a + "").charAt(1)); return 1 == a ? "st" : 2 == a ? "nd" : 3 == a ? "rd" : "th" }();
  let dayOfMonth = today + ( _day < 10) ? _day + domEnder : _day + domEnder;
  let todayMsg = dayOfWeek + ", " + dayOfMonth;
  document.getElementsByClassName('today')[0].textContent = todayMsg;

  currentMonth = new Month(_year, _month);
  updateCalendar();
}

async function fetchEvents() {
  const response = await fetch('get_events.php')
  const results = await response.json()
  
  if (results.success === false) {
    console.warn('Error fetching events', results)
  }

  return results
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initialize)
} else {
  initialize();
}


