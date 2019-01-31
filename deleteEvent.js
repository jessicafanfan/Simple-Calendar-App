function onDeleteEvent() {
  const pathToPhpFile = 'deleteEvent_ajax.php';
  const data = { token: savedToken,
  event_id: $('#edit-event-id').val()};
  console.log(data);
  $.ajax({
    url: pathToPhpFile ,
    type:'POST',
    dataType: 'text',
    data,
    success (response) {
      const result = JSON.parse(response);
      
      if (!result.success) {
        alert(result.message);
        // $("#message").html("<p class='error'>Failed to delete event!</p>");
        return
      }
      $('#editEvent-dialog').dialog('close');
      updateCalendar();
    }
  })
}

const deleteButton = document.getElementById("deleteEvent-button")

if (deleteButton) {
  deleteButton.addEventListener("click", onDeleteEvent, false);
}
