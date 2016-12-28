$( document ).ready(function() {
    var tid = setInterval(check, 2000);
    check();
    function check() {
      $.ajax({
          type: "GET",
          url: "ajax_getnc.php",
          encode: true,
          cache: false,
      }).done(
          function(result) {
            $("#ncounter").html(result);
          });
    }
});
