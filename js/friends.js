function accept_freq(uid)
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
              reload_friends(1);
              window.location = "profile?uid=".concat(uid);
              
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function reject_freq(uid)
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
              reload_friends(1);
              window.location = "profile?uid=".concat(uid);
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function cancel_freq(uid)
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
              reload_friends(1);
              window.location = "profile?uid=".concat(uid);
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function send_freq(uid)
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
              reload_friends(1);
              window.location = "profile?uid=".concat(uid);
          } else {
              // failed
              alert("Try again later.")
          }
      });
}
function unfriend(uid)
{
  data = {
    o : 'u',
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
              reload_friends(1);
              window.location = "profile?uid=".concat(uid);
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
