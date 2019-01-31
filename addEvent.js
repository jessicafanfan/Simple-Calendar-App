
function AddEvent(event){
  $("#addEvent-dialog").dialog();
}

document.getElementById('addEvent').addEventListener("click",AddEvent);
document.getElementById("addEvent-button").addEventListener("click", onAddEvent, false);

function onAddEvent() {
const pathToPhpFile = 'addEvent_ajax.php';
const data = { name: $('#event-name').val(),

event_type: $('#event-type').val(),
event_date: $('#event-date').val(),
start_time: $('#event-start-time').val(),
end_time: $('#event-end-time').val()
};
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
          // $("#message").html("<p class='error'>Event added!</p>");
          alert(result.message);
          $('#addEvent-dialog').dialog('close');
         
           updateCalendar();

        }
          else {
          alert(result.message);
        }}
    })
}
