function editEvent(eventid){
  //ajax page pass this event id and get the response as the values 
  ajaxEditEvent(eventid);
  $("#editEvent-dialog").dialog();
}

//document.getElementsByClassName('event')[0].addEventListener("click", editEvent);



function ajaxEditEvent(eventid){
const pathToPhpFile = 'getEvent_ajax.php';
const data = { 
  eventid: eventid};



  $.ajax(
    {
        url: pathToPhpFile ,
        type:'POST',
        dataType: 'text',
        data: data,
        success: function(response)
        {
          const result = JSON.parse(response);
          if(result.success){
            $('#edit-event-name').val(result.event_name);
            $('#edit-event-type').val(result.event_type);
            $('#edit-event-date').val(result.event_date);
            $('#edit-event-start-time').val(result.start_time);
            $('#edit-event-end-time').val(result.end_time);
            $('#edit-event-id').val(result.event_id);
            
          }
        }
    })
}
//async
 function onEditEvent() {
  console.log("clicked");
  const pathToPhpFile = 'editEvent_ajax.php';
  data = {
    token: savedToken,
    name: $('#edit-event-name').val(),
    event_type: $('#edit-event-type').val(),
    event_date: $('#edit-event-date').val(),
    start_time: $('#edit-event-start-time').val(),
    end_time: $('#edit-event-end-time').val(),
    event_id: $('#edit-event-id').val(),
    event_username: $('#edit-event-username').val(),
    group_event_username: $('#group-event-username').val()
  };

  console.log(data);

  

    fetch(pathToPhpFile, {
      method: 'POST',
      body: JSON.stringify(data),
      headers: { 'content-type': 'application/json' }
    })
    .then(response => response.json())
    .then(function(info){
      console.log(info);
      if(info.success){
         alert(info.message);
         $('#editEvent-dialog').dialog('close');
          updateCalendar();
      }
      else{
        alert(info.message);
       }
    });
}
document.getElementById("saveChanges-button").addEventListener("click", onEditEvent);