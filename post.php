<!--  view and submit modes should be implemented, $_GET['mode']={'v','s'} -->
<?php
if ($_GET['mode'] == 'v') {
    // view post with id = $_GET['id'] and make sure to display number of likes and an expandable comments section
} else {
    // display the post form, the posting operation should be handled in ajax
}
