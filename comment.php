<!--  view and submit modes should be implemented, $_GET['mode']={'v','s'} -->
<?php
if ($_GET['mode'] == 'v') {
    // view comment with id = $_GET['id'] and make sure to display number of likes
} else {
    // display the comment form, the commenting operation should be handled in ajax
}
