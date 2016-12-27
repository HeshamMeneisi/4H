<!--  view and submit modes should be implemented, $_GET['mode']={'v','s'} -->
<?php
include_once 'db.php';

// Handle invalid invoking

if (!isset($_GET['mode']) || !isset($_GET['id'])) {
	echo "Error retrieving comment.";
}
else {
	if ($_GET['mode'] == 'v') {

		// view comment with id = $_GET['id'] and make sure to display number of likes

		if (isset($_GET['id'])) {
			$comments = fetch_comments($_GET['id'], $pdo);
			if ($comments) {
				echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Comments</h3>';
				foreach($comments as $comment) {
					$commenter = fetch_commenter_name($comment['cuid'], $pdo);
					$commenter_name = $commenter['fname'] . ' ' . $commenter['lname'] . ' (' . $commenter['nickname'] . ')';
					$comment_time = $comment['ctime'];
					$comment_content = $comment['caption'];
					echo '<br/><br/>' . $commenter_name . ' at ' . $comment_time;
					$fetched_comment_likes = fetch_comment_likes($comment['cid'], $pdo);
					echo '<br />' . $comment_content;
					if ($fetched_comment_likes) {
						$comment_likes = $fetched_comment_likes->fetchAll(PDO::FETCH_ASSOC);

						// One like

						if ($fetched_comment_likes->rowCount() == 1) {
							$liker = fetch_name($comment_likes[0]['uid'], $pdo);
							echo '<br/>' . $liker['fname'] . ' ' . $liker['lname'] . ' likes this comment.';
						}

						// Two likes

						elseif ($fetched_comment_likes->rowCount() == 2) {
							$first_liker = fetch_name($comment_likes[0]['uid'], $pdo);
							$second_liker = fetch_name($comment_likes[1]['uid'], $pdo);
							echo '<br/>' . $first_liker['fname'] . ' ' . $first_liker['lname'] . ' and ' . $second_liker['fname'] . ' ' . $second_liker['lname'] . ' like this comment.';
						}

						// More than two likes

						else {
							$liker = fetch_name($comment_likes[0]['uid'], $pdo);
							echo '<br/>' . $liker['fname'] . ' ' . $liker['lname'] . ' and ' . ($fetched_comment_likes->rowCount() - 1) . ' others like this comment.';
						}
					}
					else {
						echo '<br/>No likes yet';
					}
				}
			}
		}
	}
	else {

		// display the comment form, the commenting operation should be handled in ajax

	}
}

// This function returns the name fields fetched via user id

function fetch_commenter_name($user_id, $pdo)
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

// This function returns the comments of a post fetched via post id

function fetch_comments($post_id, $pdo)
{
	$comments_fetcher = $pdo->prepare('SELECT * FROM comment WHERE pid=:pid');
	if (!$comments_fetcher->execute(array(
		':pid' => $post_id
	))) {
		throw new Exception('DB connection failed.');
	}
	elseif ($comments_fetcher->rowCount() > 0) {
		return $comments_fetcher->fetchAll(PDO::FETCH_ASSOC);
	}

	return null;
}

// This function returns the likes of a comment fetched via post id

function fetch_comment_likes($comment_id, $pdo)
{
	$comment_likes_fetcher = $pdo->prepare('SELECT uid FROM likes_comment WHERE cid=:cid');
	if (!$comment_likes_fetcher->execute(array(
		':cid' => $comment_id
	))) {
		throw new Exception('DB connection failed.');
	}
	elseif ($comment_likes_fetcher->rowCount() > 0) {
		return $comment_likes_fetcher;
	}

	return null;
}