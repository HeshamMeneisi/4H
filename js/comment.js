function like_comment(puid, pid, cid) {
    data = {
        t: 'c',
        puid: puid,
        pid: pid,
        cid: cid
    };
    $.ajax({
        type: "POST",
        url: "ajax_like.php",
        data: data,
        dataType: 'json',
        encode: true,
        cache: false,
    }).done(
        function(result) {
            if (result['success']) {
                reload_post(puid, pid, true);
            } else {
                // failed
                alert("Try again later.")
            }
        });
}

function comment(puid, pid) {
    var caption = $('#' + puid + '_' + pid + ' #comment_cap').val();
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
                    reload_post(puid, pid, true);
                } else {
                    // failed
                    alert("Try again later.")
                }
            });
    }
}

function show_comments(puid, pid) {
    conid = puid + '_' + pid;
    $('#' + conid + ' #showComm').hide();
    $('#' + conid + ' #hideComm').show();
    $('#' + conid + ' #commentsec').show();
}

function hide_comments(puid, pid) {
    conid = puid + '_' + pid;
    $('#' + conid + ' #commentsec').hide();
    $('#' + conid + ' #showComm').show();
    $('#' + conid + ' #hideComm').hide();
}
