<script src="js/timeline.js"></script>
<script src="js/post.js"></script>
<script src="js/comment.js"></script>
<container id='timeline'>
<?php
include_once 'core.php';

include_once 'db.php';

$onprof = isset($_GET['p']);
echo "<script>set_timeline_mode({$onprof})</script>";

if (is_logged() && !($onprof && isset($_GET['uid']))) {
	$_GET['mode'] = 's';
	include 'post.php';

}

if ($onprof) {
	if (isset($_GET['uid'])) {
		$uid = $_GET['uid'];
	}
	else {
		$uid = get_user() ['uid'];
	}

	if (is_friend($uid, $pdo)) {

		// display the user's posts

		$posts = fetch_posts_of($uid, false, $pdo);
	}
	else {

		// only public posts

		$posts = fetch_posts_of($uid, true, $pdo);
	}

	foreach($posts as $post) {
		$_GET['mode'] = 'v';
		$_GET['post'] = $post;
		include 'post.php';

	}
}
else {

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
		foreach($posts as $post) {
			$_GET['mode'] = 'v';
			$_GET['post'] = $post;
			include 'post.php';

		}
	}
}

function fetch_posts_of($uid, $publiconly, $pdo)
{
	$sql = 'SELECT * FROM post WHERE puid=:uid';
	if ($publiconly) {
		$sql.= ' AND privacy=0';
	}

	$sql.= ' ORDER BY `ptime` DESC';
	$st = $pdo->prepare($sql);
	if (!$st->execute(array(
		':uid' => $uid
	))) {
		throw new Exception('DB connection failed.');
	}
	else {
		return $st->fetchAll(PDO::FETCH_ASSOC);
	}
}

echo '</container>';
?>