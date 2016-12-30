<?php
include_once 'core.php';

include_once 'db.php';

$return = array();

if (is_logged()) {
	if (isset($_POST['d']) && isset($_POST['puid']) && isset($_POST['pid']) && $_POST['puid'] == get_user() ['uid']) {
		$st = $pdo->prepare('DELETE FROM post WHERE puid=:puid AND pid=:pid');
		$data = array(
			':puid' => $_POST['puid'],
			':pid' => $_POST['pid']
		);
		if (!$st->execute($data)) {
			$return['success'] = false;
		}
		else {
			$return['success'] = true;
		}
	}
	elseif (isset($_POST['caption'])) {
		$caption = $_POST['caption'];
		if (isset($_POST['image'])) {
			$image = $_POST['image'];
		}

		if (!$_POST['privacy']) {
			$privacy = false;
		}
		else {
			$privacy = true;
		}

		$user = get_user();
		$post_status = $pdo->prepare('INSERT INTO post(`puid`, `caption`, `privacy`, `ptime`) VALUES (:puid, :caption, :privacy,NOW())');
		$post_insert_data = array(
			':puid' => $user['uid'],
			':caption' => $caption,
			':privacy' => $privacy
		);
		if (!$post_status->execute($post_insert_data)) {
			$return['success'] = false;
		}
		else {
			$return['success'] = true;
		}
	}
	else {
		$return['success'] = false;
	}
}

echo json_encode($return);