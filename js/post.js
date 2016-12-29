function delete_post(puid, pid, getdata) {
    $.ajax({
        type: "POST",
        url: "ajax_post.php",
        data: {
            d: 1,
            puid: puid,
            pid: pid
        },
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

function like_post(puid, pid) {
    data = {
        t: 'p',
        puid: puid,
        pid: pid
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
                conid = puid + '_' + pid;
                csv = $('#' + conid + ' #commentsec').is(':visible');
                reload_post(puid, pid, csv);
            } else {
                // failed
                alert("Try again later.")
            }
        });
}

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

function reload_post(puid, pid, showcomments) {
    conid = puid + '_' + pid;
    data = {
        mode: 'v',
        puid: puid,
        id: pid,
        aj: '1'
    };
    $.ajax({
        type: "GET",
        url: "post.php",
        data: data,
        encode: true,
        cache: false,
    }).done(
        function(result) {
            $('#' + conid).replaceWith(result);
            if (showcomments) {
                show_comments(puid, pid);
            }
        });
}
