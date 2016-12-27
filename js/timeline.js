function update_timeline(getdata)
{
  getdata['aj'] = 1;
  $.ajax({
      type: "GET",
      url: "timeline.php",
      data: getdata,
      encode: true,
  }).done(
      function(result) {
          $("#timeline").html(result);
      }).fail(function(xhr, status, error){
        alert("failed");
      });
}
