function post(getdata) {
    var caption = $('#caption').val();
    var privacy = $('#privacy option:selected').val();
    var post_data = {
        'caption': caption,
        'privacy': privacy
    };
    if (caption == '') {
        alert("Oops!\nPlease enter something before posting");
    } else {
        $.ajax({
            type: "POST",
            url: "ajax_post.php",
            data: post_data,
            dataType: 'json',
            encode: true,
            cache: false,
        }).done(
            function(result) {
                if (result['success']) {
                    update_timeline(getdata);
                } else {
                    // failed
                    alert("Try again later.")
                }
            });
    }
}

function reload_post(puid, pid, getdata)
{
  conid = puid+'_'+pid;
  data = {
    mode : 'v',
    puid : puid,
    id : pid,
    p : getdata['p']?1:0,
    aj : '1'
  };
  $.ajax({
      type: "GET",
      url: "post.php",
      data: data,
      encode: true,
      cache: false,
  }).done(
      function(result) {
          $('#'+conid).html(result)
      });
}
