<!--  view, submit and post modes should be implemented, $_GET['mode']={'v','s','p'} -->
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

        if (isset($_GET['id'])) {

            // Fetch post data

            $the_post = fetch_post($_GET['id'], $pdo);
            $name = fetch_name($the_post['puid'], $pdo);
            $poster_name = $name['fname'].' '.$name['lname'];
            $nickname = ' ('.$name['nickname'].') ';
            $caption = $the_post['caption'];
            $time = $the_post['ptime'];
            $fetched_likes = fetch_likes($_GET['id'], $pdo);
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
        } else {
            echo 'Unable to retrieve post.';
        }
    } elseif ($_GET['mode'] == 'p') {
        // display the post form, the posting operation should be handled in ajax
              // Text area
              echo '<div class="postform"><form><textarea id="caption" rows="10" cols="85" placeholder="What\'s on your mind?"></textarea>';
              //Privacy menu
              echo '<select name="privacy" id="privacy" style="width:100px;margin-right:10px;"><option value="0">Public</option><option value="1">Private</option></select>';
              // Submit button
              echo '<button id="submitPost">Post</button>';
              //Form end
              echo '</form></div>';
    }
}

// This function returns a post fetched via post id

function fetch_post($post_id, $pdo)
{
    $post_fetcher = $pdo->prepare('SELECT * FROM post WHERE pid=:pid');
    if (!$post_fetcher->execute(array(
        ':pid' => $post_id,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($post_fetcher->rowCount() == 1) {
        return $post_fetcher->fetch(PDO::FETCH_ASSOC);
    }
}

// This function returns the name fields fetched via user id

function fetch_name($user_id, $pdo)
{
    $name_fetcher = $pdo->prepare('SELECT fname,lname,nickname FROM user WHERE uid=:uid');
    if (!$name_fetcher->execute(array(
        ':uid' => $user_id,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($name_fetcher->rowCount() == 1) {
        return $name_fetcher->fetch(PDO::FETCH_ASSOC);
    }
}

// This function returns the likes of a post fetched via post id

function fetch_likes($post_id, $pdo)
{
    $fetched_likes_fetcher = $pdo->prepare('SELECT uid FROM likes_post WHERE pid=:pid');
    if (!$fetched_likes_fetcher->execute(array(
        ':pid' => $post_id,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($fetched_likes_fetcher->rowCount() > 0) {
        return $fetched_likes_fetcher;
    }

    return null;
}
