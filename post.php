<!--  view, submit modes should be implemented, $_GET['mode']={'v','s'} -->
<?php

require_once 'user.php';
include_once 'db.php';

if (!isset($_GET['aj'])) {
    include_once 'hud.php';
}

// Handle invalid invoking

if (!isset($_GET['mode'])) {
    echo 'Error retrieving post.';
} else {
    if ($_GET['mode'] == 'v') {

        // view post with id = $_GET['id'] and make sure to display number of likes and an expandable comments section
        if (isset($_GET['post'])) {
            $the_post = $_GET['post'];
        } elseif (isset($_GET['id']) && isset($_GET['puid'])) {
            // Fetch post data
            $the_post = fetch_post($_GET['id'], $_GET['puid'], $pdo);
        } else {
            echo 'Unable to retrieve post.';
        }
        $puid = $the_post['puid'];
        $pid = $the_post['pid'];
        $name = fetch_name($the_post['puid'], $pdo);
        $poster_name = $name['fname'].' '.$name['lname'];
        $nickname = ' ('.$name['nickname'].') ';
        $caption = $the_post['caption'];
        $time = $the_post['ptime'];
        $fetched_likes = fetch_likes($pid, $puid, $pdo);
        $conid = $puid.'_'.$pid;
        if (!isset($_GET['aj'])) {
            echo "<container id={$conid}>";
        }
        echo "<div id='post'>";
            // Display poster name and post time

        echo '<div class="posthead">'.$poster_name.$nickname.'</div><div id="postdate">Posted at: '.date('l, F jS, Y', strtotime($time)).'</div><div class="postcontent">'.$caption.'</div>';

        // Check for post likes
        echo '<div class="likes">';
        if ($fetched_likes) {
            $likes = $fetched_likes->fetchAll(PDO::FETCH_ASSOC);
            $uid = get_user()['uid'];
            $liked = false;

            foreach ($likes as $like) {
                if ($like['uid'] == $uid) {
                    $liked = true;
                    break;
                }
            }

            // One like

            if ($fetched_likes->rowCount() == 1) {
                $liker = fetch_name($likes[0]['uid'], $pdo);
                echo $liker['fname'].' '.$liker['lname'].' likes this.';
            }

            // Two likes

            elseif ($fetched_likes->rowCount() == 2) {
                $first_liker = fetch_name($likes[0]['uid'], $pdo);
                $second_liker = fetch_name($likes[1]['uid'], $pdo);
                echo $first_liker['fname'].' '.$first_liker['lname'].' and '.$second_liker['fname'].' '.$second_liker['lname'].' like this.';
            }

            // More than two likes

            else {
                $liker = fetch_name($likes[0]['uid'], $pdo);
                echo $liker['fname'].' '.$liker['lname'].' and '.($fetched_likes->rowCount() - 1).' others like this.';
            }
        }

        // No likes

        else {
            echo 'No likes yet';
            $liked = false;
        }

        if (!$liked) {
            echo "<button class='likebtn' onclick='like_post({$puid},{$pid})'>Like</button>";
        }

        echo '</div>';
        $_GET['puid'] = $the_post['puid'];
        $_GET['pid'] = $the_post['pid'];
        include 'comment.php';
        $_GET['mode'] = 's';
        include 'comment.php';
        echo '</div>';
        if (!isset($_GET['aj'])) {
            echo '</container>';
        }
    } elseif ($_GET['mode'] == 's') {
        // display the post form, the posting operation should be handled in ajax
              // Text area
              echo '<div class="postform"><table><textarea id="caption" rows="10" cols="85" placeholder="What\'s on your mind?"></textarea>';
              
              // Submit button
              $gdata = json_encode($_GET);
        echo "<button id='submitPost' onclick='post({$gdata})'>Post</button>";
              //Form end
        //Privacy menu
              echo '<select name="privacy" id="privacy" style="width:100px;margin-right:10px;"><option value="0">Public</option><option value="1">Private</option></select>';
              echo '</table></div>';
    }
}
