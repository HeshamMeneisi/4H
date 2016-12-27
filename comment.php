<!--  view and submit modes should be implemented, $_GET['mode']={'v','s'} -->
<?php
include_once 'db.php';

// Handle invalid invoking

if (!isset($_GET['mode']) || !isset($_GET['pid'])) {
    echo 'Error retrieving comment.';
} else {
    if ($_GET['mode'] == 'v') {

        // view comments for post with id = $_GET['pid'] and make sure to display number of likes

        if (isset($_GET['pid'])) {
            if (isset($_GET['puid'])) {
                $puid = $_GET['puid'];
            } else {
                $puid = get_user()['uid'];
            }
            $comments = fetch_comments($_GET['pid'], $puid, $pdo);
            if ($comments) {
                echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Comments</h3>';
                foreach ($comments as $comment) {
                    $commenter = fetch_commenter_name($comment['cuid'], $pdo);
                    $commenter_name = $commenter['fname'].' '.$commenter['lname'].' ('.$commenter['nickname'].')';
                    $comment_time = $comment['ctime'];
                    $comment_content = $comment['caption'];
                    echo '<br/><br/>'.$commenter_name.' at '.$comment_time;
                    $fetched_comment_likes = fetch_comment_likes($puid, $_GET['puid'], $comment['cid'], $puid, $pdo);
                    echo '<br />'.$comment_content;
                    if ($fetched_comment_likes) {
                        $comment_likes = $fetched_comment_likes->fetchAll(PDO::FETCH_ASSOC);

                        // One like

                        if ($fetched_comment_likes->rowCount() == 1) {
                            $liker = fetch_name($comment_likes[0]['uid'], $pdo);
                            echo '<br/>'.$liker['fname'].' '.$liker['lname'].' likes this comment.';
                        }

                        // Two likes

                        elseif ($fetched_comment_likes->rowCount() == 2) {
                            $first_liker = fetch_name($comment_likes[0]['uid'], $pdo);
                            $second_liker = fetch_name($comment_likes[1]['uid'], $pdo);
                            echo '<br/>'.$first_liker['fname'].' '.$first_liker['lname'].' and '.$second_liker['fname'].' '.$second_liker['lname'].' like this comment.';
                        }

                        // More than two likes

                        else {
                            $liker = fetch_name($comment_likes[0]['uid'], $pdo);
                            echo '<br/>'.$liker['fname'].' '.$liker['lname'].' and '.($fetched_comment_likes->rowCount() - 1).' others like this comment.';
                        }
                    } else {
                        echo '<br/>No likes yet';
                    }
                }
            }
        }
    } elseif ($_GET['mode'] == 's') {
        // display the comment form, the commenting operation should be handled in ajax
    } else {
        echo 'Error retrieving comment.';
    }
}

// This function returns the name fields fetched via user id
