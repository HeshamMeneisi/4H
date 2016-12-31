var mode = 0;

function set_timeline_mode(m) {
    mode = m;
}

function update_timeline() {
    data = {
        aj: 1,
        p: mode
    }
    $.ajax({
        type: "GET",
        url: "timeline.php",
        data: data,
        encode: true,
    }).done(
        function(result) {
            $("#timeline").replaceWith(result);
            timelineupdated = true;
        }).fail(function(xhr, status, error) {
        alert("failed");
    });
}
