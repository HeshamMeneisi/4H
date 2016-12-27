$(document).ready(function() {
    $("#submitPost").click(function() {
        var caption = $('#caption').val();
        var privacy = $('#privacy option:selected').val();
        var post_data = 'caption=' + caption + '&privacy=' + privacy;
        if (caption=='') {
            alert("Oops!\nPlease enter something before posting");
        } else {
            $.ajax({
                type: "POST",
                url: "ajax_post.php",
                data: post_data,
                cache: false,
                success: function(result) {
                    $('#caption').val('');
                }
            });
        }
        return false;
    });
});