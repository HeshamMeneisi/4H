<!-- should support default query mode and advanced search mode $_GET['mode'] = {'q','a'} -->
<?php
echo '<title>Search - Hallo</title>';
include_once 'core.php';
include_once 'db.php';
include_once 'hud.php';
echo '<h1 class="page_title">Search</h1><div class="friends_container">';
if (isset($_GET['query'])) {
    if ($_GET['mode'] == 'q') {
        $q = $_GET['query'];
        if (preg_match('#^email:#i', $q) === 1 || preg_match('#^name:#i', $q) === 1 || preg_match('#^location:#i', $q) === 1) {
            $values = explode(' ', $q);
            $type = strtolower($values[0]);
            if (count($values) > 1) {
                if ($type == 'email:') {
                    $user = fetch_user_with_email($values[1], $pdo);
                    if ($user) {
                        $_GET['person'] = $user;
                        include 'person.php';
                    } else {
                        echo 'User not found.</div>';
                    }
                } elseif ($type == 'name:') {
                    $fname = $values[1];
                    $lname = null;
                    if (count($values) > 2) {
                        $lname = $values[2];
                    }
                    $users = fetch_users_with_name($fname, $lname, $pdo);
                    if ($users) {
                        echo '<h2 style="color:#444;">Matches</h2>';
                        foreach ($users as $user) {
                            $_GET['person'] = $user;
                            include 'person.php';
                            echo '<br/>';
                        }
                        echo '</div>';
                    } else {
                        echo 'No matching users.</div>';
                    }
                } elseif ($type == 'location:') {
                    $city = $values[1];
                    $country = null;
                    if (count($values) > 2) {
                        $country = $values[2];
                    }
                    $users = fetch_users_in($city, $country, $pdo);
                    if ($users) {
                        foreach ($users as $user) {
                            $_GET['person'] = $user;
                            include 'person.php';
                        }
                    } else {
                        echo 'No matching users.</div>';

                    }
                }
            } else {
                echo 'Please specify a query.</div>';
            }
        } else {
            // search for posts/comments containing $q in caption
            $resposts = fetch_posts_matching($q, $pdo);
            if ($resposts) {
                foreach ($resposts as $post) {
                    $_GET['mode'] = 'v';
                    $_GET['post'] = $post;
                    include 'post.php';
                }
            }
            else{
                echo 'No matching posts.</div>';

            }
        }
    }   
} else {
    echo 'Nothing found.</div>';
}
