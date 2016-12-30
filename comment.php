<!--  view and submit modes should be implemented, $_GET['mode']={'v','s'} -->
<?php
include_once 'db.php';
include_once 'core.php';

// Handle invalid invoking

if (!isset($_GET['mode']) || !isset($_GET['pid'])) {
    echo 'Error retrieving comment.';
} else {
    if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        if (isset($_GET['puid'])) {
            $puid = $_GET['puid'];
        } else {
            $puid = get_user()['uid'];
        }
        if ($_GET['mode'] == 'v') {

        // view comments for post with id = $pid and make sure to display number of likes
            $comments = fetch_comments($pid, $puid, $pdo);
            echo '<hr><div id="commentslabel">Comments</div>';
            if ($comments) {
                echo "<button class='shbtn' id='showComm' onclick='show_comments({$puid},{$pid})'>Show comments</button>";
                echo "<button class='shbtn' id='hideComm' onclick='hide_comments({$puid},{$pid})'>Hide comments</button>";
                echo "<div id='commentsec'>";
                foreach ($comments as $comment) {
                    echo '<div class="post_comment">';
                    $commenter = fetch_commenter_name($comment['cuid'], $pdo);
                    $link = './profile?uid='.$comment['cuid'];
                    $commenter_name = $commenter['fname'].' '.$commenter['lname']."<div class='nickname'>(<a href={$link}>".$commenter['nickname'].'</a>)</div>';
                    $comment_time = $comment['ctime'];
                    $comment_content = $comment['caption'];
                    process($comment_content);
                    if (!file_exists('content/users/'.$puid.'/profile_picture.png')) {
                        $profile_picture = "content/static/default_picture/{$user['gender']}.jpg";
                    } else {
                        $profile_picture = 'content/users/'.$puid.'/profile_picture.png';
                    }
                    echo '<img class="comment_thumb" src="'.$profile_picture.'"/profile_picture.png"/><div id="commenthead">'.$commenter_name.'</div><div id="postdate">Commented at: '.date('l, F jS, Y', strtotime($time)).'</div>';
                    $cid = $comment['cid'];
                    $fetched_comment_likes = fetch_comment_likes($puid, $pid, $cid, $pdo);
                    echo '<div id="commentbody">'.$comment_content.'</div>';

                    echo '<div class="comment_like">';
                    $like_icon = '<img id="like_icon" src="content/static/ui/like.png" height="12px" width="12px"/>';
                    if ($fetched_comment_likes) {
                        $comment_likes = $fetched_comment_likes->fetchAll(PDO::FETCH_ASSOC);

                        $uid = get_user()['uid'];
                        $liked = false;

                        foreach ($comment_likes as $like) {
                            if ($like['uid'] == $uid) {
                                $liked = true;
                                break;
                            }
                        }
                        // One like
                        if ($fetched_comment_likes->rowCount() == 1) {
                            $liker = fetch_name($comment_likes[0]['uid'], $pdo);
                            echo $like_icon.$liker['fname'].' '.$liker['lname'].' likes this comment.';
                        }

                        // Two likes

                        elseif ($fetched_comment_likes->rowCount() == 2) {
                            $first_liker = fetch_name($comment_likes[0]['uid'], $pdo);
                            $second_liker = fetch_name($comment_likes[1]['uid'], $pdo);
                            echo $like_icon.$first_liker['fname'].' '.$first_liker['lname'].' and '.$second_liker['fname'].' '.$second_liker['lname'].' like this comment.';
                        }

                        // More than two likes

                        else {
                            $liker = fetch_name($comment_likes[0]['uid'], $pdo);
                            echo $like_icon.$liker['fname'].' '.$liker['lname'].' and '.($fetched_comment_likes->rowCount() - 1).' others like this comment.';
                        }
                    } else {
                        echo $like_icon.'No likes yet';
                        $liked = false;
                    }
                    echo '</div>';
                    if (!$liked) {
                        echo "<button class='likebtn' onclick='like_comment({$puid},{$pid},{$cid})'>Like</button>";
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
        } elseif ($_GET['mode'] == 's') {
            // display the comment form, the commenting operation should be handled in ajax
            // Text area
            echo "<div class='commentform'><table><textarea id='comment_cap' rows='10' cols='85' placeholder='Leave a comment!'></textarea>";
            // Submit button
            echo "<button id='submitComment' onclick='comment({$puid},{$pid})'>Comment</button>";
            //Form end
            echo '</table></div>';
        } else {
            echo 'Error retrieving comment.';
        }
    } else {
        echo 'Error retrieving comment.';
    }
}
