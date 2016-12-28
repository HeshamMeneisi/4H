<!-- should support default query mode and advanced search mode $_GET['mode'] = {'q','a'} -->
<?php
include_once 'user.php';
include_once 'db.php';
if (isset($_GET['query'])) {
    if ($_GET['mode'] == 'q') {
        $q = $_GET['query'];
        // search for posts/comments containing $q in caption
        $resposts = fetch_posts_matching($q, $pdo);
        if ($resposts) {
            foreach ($resposts as $post) {
                $_GET['mode'] = 'v';
                $_GET['post'] = $post;
                include 'post.php';
            }
        }
    } else {
        // use advaned search values supplied from searchform.php
    }
} else {
    echo 'Nothing found.';
}
