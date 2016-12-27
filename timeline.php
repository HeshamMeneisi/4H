<!-- a post form -->
<!-- some of the most recent friend posts, plus some public posts -->
<!-- should use post.php in view mode $_GET['mode']='v' -->
<?php
if (!isset($_GET['aj'])):
 ?>
 <script src="js/timeline.js"></script>
 <script src="js/post.js"></script>
 <script src="js/comment.js"></script>
 <container id='timeline'>
<?php
endif;
include_once 'user.php';
include_once 'db.php';

$onprof = isset($_GET['p']);

if (is_logged() && !($onprof && isset($_GET['uid']))) {
    $_GET['mode'] = 's';
    include 'post.php';
}
if ($onprof) {
    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];
    } else {
        $uid = get_user()['uid'];
    }
    // display the user's posts
    $posts = fetch_posts_of($uid, $pdo);
    foreach ($posts as $post) {
        $_GET['mode'] = 'v';
        $_GET['post'] = $post;
        include 'post.php';
    }
} else {
    // display the time line
    // first get the most active public posts today, most commented and most liked
    $_GET['post'] = fetch_most_commented($pdo);
    if ($_GET['post']) {
        $_GET['mode'] = 'v';
        include 'post.php';
    }
    $_GET['post'] = fetch_most_liked($pdo);
    if ($_GET['post']) {
        $_GET['mode'] = 'v';
        include 'post.php';
    }

    $posts = fetch_recent_friend_posts($pdo);
    if ($posts) {
        foreach ($posts as $post) {
            $_GET['mode'] = 'v';
            $_GET['post'] = $post;
            include 'post.php';
        }
    }
}

function fetch_posts_of($uid, $pdo)
{
    $st = $pdo->prepare('SELECT * FROM post WHERE puid=:uid ORDER BY `ptime` DESC');
    if (!$st->execute(array(':uid' => $uid))) {
        throw new Exception('DB connection failed.');
    } else {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
if (!isset($_GET['aj'])) {
    echo '</container>';
}
?>
