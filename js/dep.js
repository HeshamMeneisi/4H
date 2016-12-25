_sub = false;
function sub(){
  if(_sub) return;
  _sub = true;
  var did = $('#dsel').val();
  errors = {};
  try {
      updateErrors("#dform");

      // if no errors, submit to server
      if (jQuery.isEmptyObject(errors)) {
          dispWaiting('dsub');
          var data = {
              'id' :  did,
              'op': 'sdid'
          };
          $.ajax({
              type: 'POST',
              url: 'auth.php',
              data: data,
              dataType: 'json',
              encode: true
          }).done(function(res) {
              if (res['success']) {
                  window.location.href = 'index.php';
              }
              stopWaiting('dsub');
              errors = res['errors'];
              updateErrors("#dform");
              _sub = false;
          });
      } else {
          updateErrors("#dform");
          _sub = false;
      }
  } catch (err) {
      console.log(err);
      _sub = false;
  }
}
