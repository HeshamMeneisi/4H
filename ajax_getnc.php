<?php
include_once 'db.php';

include_once 'core.php';

$st = $pdo->prepare('SELECT COUNT(*) AS c FROM notification WHERE uid=:uid AND seen=0');

if (!$st->execute(array(':uid' => get_user()['uid']))) {
	throw new Exception('DB connection failed.');
}
elseif ($st->rowCount() == 1) {
	echo $st->fetch(PDO::FETCH_ASSOC) ['c'];
}