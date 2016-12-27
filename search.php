<!-- should support default query mode and advanced search mode $_GET['mode'] = {'q','a'} -->
<?php
if (isset($_GET['query'])) {
    if ($_GET['mode'] == 'q') {
        $q = $_GET['query'];
        // search for posts/comments containing $q in caption
    } else {
        // use advaned search values supplied from searchform.php
    }
} else {
    echo 'Nothing found.';
}
