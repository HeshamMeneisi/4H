function comment(puid, pid) {
    var caption = $('#' + puid + '_' + pid + ' #caption').val();
    var data = {
        'puid': puid,
        'pid': pid,
        'caption': caption
    };
    if (caption == '') {
        alert("Oops!\nPlease enter something before posting");
    } else {
        $.ajax({
            type: "POST",
            url: "ajax_comment.php",
            data: data,
            dataType: 'json',
            encode: true,
            cache: false
        }).done(
            function(result) {
                if (result['success']) {
                    $('#caption').val('');
                } else {
                    // failed
                    alert("Try again later.")
                }
            });
    }
}
