function accept_freq(uid,lf)
{
  data = {
    o : 'a',
    uid : uid
  };
  $.ajax({
      type: "POST",
      url: "ajax_req.php",
      data: data,
      dataType: 'json',
      encode: true,
      cache: false,
  }).done(
      function(result) {
          if (result['success']) {
              reload_friends(lf);
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function reject_freq(uid,lf)
{
  data = {
    o : 'r',
    uid : uid
  };
  $.ajax({
      type: "POST",
      url: "ajax_req.php",
      data: data,
      dataType: 'json',
      encode: true,
      cache: false,
  }).done(
      function(result) {
          if (result['success']) {
              reload_friends(lf);
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function cancel_freq(uid,lf)
{
  data = {
    o : 'c',
    uid : uid
  };
  $.ajax({
      type: "POST",
      url: "ajax_req.php",
      data: data,
      dataType: 'json',
      encode: true,
      cache: false,
  }).done(
      function(result) {
          if (result['success']) {
              reload_friends(lf);
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function send_freq(uid,lf)
{
  data = {
    o : 's',
    uid : uid
  };
  $.ajax({
      type: "POST",
      url: "ajax_req.php",
      data: data,
      dataType: 'json',
      encode: true,
      cache: false,
  }).done(
      function(result) {
          if (result['success']) {
              reload_friends(lf);
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function reload_friends(lf)
{
  data = {
    r:1,
    l:lf
  };
  $.ajax({
      type: "GET",
      url: "friends.php",
      data : data,
      encode: true,
      cache: false,
  }).done(
      function(result) {
          $('#friends').html(result)
      });
}
