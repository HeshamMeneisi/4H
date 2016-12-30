<?php
include_once 'core.php';

include_once 'db.php';

$return = array();

if (is_logged() && isset($_POST['puid']) && isset($_POST['pid']) && isset($_POST['caption'])) {
	$puid = $_POST['puid'];
	$pid = $_POST['pid'];
	$caption = $_POST['caption'];
}
else {
	$return['success'] = false;
	echo json_encode($return);
	die();
}

$user = get_user();
$st = $pdo->prepare('INSERT INTO comment(`cuid`, `puid`, `pid`, `caption`, `ctime`) VALUES (:cuid, :puid, :pid, :caption, NOW())');
$data = array(
	':cuid' => $user['uid'],
	':puid' => $puid,
	':pid' => $pid,
	':caption' => $caption,
);

if (!$st->execute($data)) {
	$return['success'] = false;
}
else {
	$return['success'] = true;
	create_notf_comment($puid, $pid, $pdo);
}

echo json_encode($return);