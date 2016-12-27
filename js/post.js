function post() {
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
                    $('#caption').val('');
                } else {
                    // failed
                    alert("Try again later.")
                }
            });
    }
}
