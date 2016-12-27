<!-- a post form -->
<!-- some of the most recent friend posts, plus some public posts -->
<!-- should use post.php in view mode $_GET['mode']='v' -->

<?php
include_once 'user.php';
include_once 'db.php';

if (is_logged()) {
    $_GET['mode'] = 'p';
    include 'post.php';

    if (isset($_GET['p'])) {
        // display the logged in user posts only
    } else {
        // display the time line
    }
}
?>
