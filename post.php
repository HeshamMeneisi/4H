<!--  view and submit modes should be implemented, $_GET['mode']={'v','s'} -->
<?php
include 'db.php';

// Handle invalid invoking

if (!isset($_GET['mode']) || !isset($_GET['id'])) {
	echo "Error retrieving post.";
}
else {
	if ($_GET['mode'] == 'v') {

		// view post with id = $_GET['id'] and make sure to display number of likes and an expandable comments section

		if (isset($_GET['id'])) {

			// Fetch post data

			$the_post = fetch_post($_GET['id'], $pdo);
			$name = fetch_name($the_post['puid'], $pdo);
			$poster_name = $name['fname'] . ' ' . $name['lname'];
			$nickname = ' (' . $name['nickname'] . ') ';
			$caption = $the_post['caption'];
			$time = $the_post['ptime'];
			$fetched_likes = fetch_likes($_GET['id'], $pdo);

			// Display poster name and post time
			echo $poster_name . $nickname . 'posted at ' . $time . '<br/>' . $caption;

			// Check for post likes

			if ($fetched_likes) {
				$likes = $fetched_likes->fetchAll(PDO::FETCH_ASSOC);

				// One like

				if ($fetched_likes->rowCount() == 1) {
					$liker = fetch_name($likes['uid'], $pdo);
					echo '<br />' . $liker['fname'] . ' ' . $liker['lname'] . ' likes this.';
				}

				// Two likes

				elseif ($fetched_likes->rowCount() == 2) {
					$first_liker = fetch_name($likes[0]['uid'], $pdo);
					$second_liker = fetch_name($likes[1]['uid'], $pdo);
					echo '<br/>' . $first_liker['fname'] . ' ' . $first_liker['lname'] . ' and ' . $second_liker['fname'] . ' ' . $second_liker['lname'] . ' like this.';
				}

				// More than two likes

				else {
					$liker = fetch_name($likes[0]['uid'], $pdo);
					echo '<br/>' . $liker['fname'] . ' ' . $liker['lname'] . ' and ' . ($fetched_likes->rowCount() - 1) . ' others like this.';
				}
			}

			// No likes

			else {
				echo '<br/>No likes yet';
			}
		}

		include 'comment.php';

	}
	else {

		// display the post form, the posting operation should be handled in ajax
		// Text area

		echo '<form><textarea id=\'post_text\' rows=\'10\' cols=\'80\'></textarea></form>';

		// Submit button

		echo '<button id=\'submitPost\'>Post</button>';
	}
}

// This function returns a post fetched via post id

function fetch_post($post_id, $pdo)
{
	$post_fetcher = $pdo->prepare('SELECT * FROM post WHERE pid=:pid');
	if (!$post_fetcher->execute(array(
		':pid' => $post_id
	))) {
		throw new Exception('DB connection failed.');
	}
	elseif ($post_fetcher->rowCount() == 1) {
		return $post_fetcher->fetch(PDO::FETCH_ASSOC);
	}
}

// This function returns the name fields fetched via user id

function fetch_name($user_id, $pdo)
{
	$name_fetcher = $pdo->prepare('SELECT fname,lname,nickname FROM user WHERE uid=:uid');
	if (!$name_fetcher->execute(array(
		':uid' => $user_id
	))) {
		throw new Exception('DB connection failed.');
	}
	elseif ($name_fetcher->rowCount() == 1) {
		return $name_fetcher->fetch(PDO::FETCH_ASSOC);
	}
}

// This function returns the likes of a post fetched via post id

function fetch_likes($post_id, $pdo)
{
	$fetched_likes_fetcher = $pdo->prepare('SELECT uid FROM likes_post WHERE pid=:pid');
	if (!$fetched_likes_fetcher->execute(array(
		':pid' => $post_id
	))) {
		throw new Exception('DB connection failed.');
	}
	elseif ($fetched_likes_fetcher->rowCount() > 0) {
		return $fetched_likes_fetcher;
	}

	return null;
}