<!--  view, post modes should be implemented, $_GET['mode']={'v','p'} -->
<?php

require_once 'user.php';
include_once 'hud.php';
include_once 'db.php';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script><br/><script src="js/post.js"></script>';

// Handle invalid invoking

if (!isset($_GET['mode'])) {
    echo 'Error retrieving post.';
} else {
    if ($_GET['mode'] == 'v') {

        // view post with id = $_GET['id'] and make sure to display number of likes and an expandable comments section
        if (isset($_GET['post'])) {
            $the_post = $_GET['post'];
        } elseif (isset($_GET['id'])) {
            // Fetch post data
            $the_post = fetch_post($_GET['id'], $pdo);
        } else {
            echo 'Unable to retrieve post.';
        }
        $name = fetch_name($the_post['puid'], $pdo);
        $poster_name = $name['fname'].' '.$name['lname'];
        $nickname = ' ('.$name['nickname'].') ';
        $caption = $the_post['caption'];
        $time = $the_post['ptime'];
        $fetched_likes = fetch_likes($the_post['pid'], $pdo);
        echo '<div id="post">';
            // Display poster name and post time

            echo '<div class="posthead">'.$poster_name.$nickname.'posted at '.$time.'</div><div class="postcontent">'.$caption.'</div>';

            // Check for post likes
            echo '<div class="likes">';
        if ($fetched_likes) {
            $likes = $fetched_likes->fetchAll(PDO::FETCH_ASSOC);

                // One like

                if ($fetched_likes->rowCount() == 1) {
                    $liker = fetch_name($likes['uid'], $pdo);
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
            }
        echo '</div>';
        include 'comment.php';
        echo '</div>';
    } elseif ($_GET['mode'] == 'p') {
        // display the post form, the posting operation should be handled in ajax
              // Text area
              echo '<div class="postform"><form><textarea id="caption" rows="10" cols="85"></textarea>';
              //Privacy menu
              echo '<select name="privacy" id="privacy" style="width:100px;margin-right:10px;"><option value="0">Public</option><option value="1">Private</option></select>';
              // Submit button
              echo '<button id="submitPost">Post</button>';
              //Form end
              echo '</form></div>';
    }
}
