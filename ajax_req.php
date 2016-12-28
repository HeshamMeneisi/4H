<?php

include_once 'user.php';
include_once 'db.php';
$return = array();
if (is_logged() && isset($_POST['o']) && isset($_POST['uid'])) {
    $uid = $_POST['uid'];
    $user = get_user();
    switch ($_POST['o']) {
      case 'a': // accept request from uid
          $st = $pdo->prepare('UPDATE `friends` SET `accepted` = b\'1\' WHERE `uid1`=:uid2 AND `uid2`=:uid1');
          $data = array(':uid1' => $user['uid'], ':uid2' => $uid);
          if (!$st->execute($data)) {
              $return['success'] = false;
          } else {
              $return['success'] = true;
          }
        break;
      case 'r': // reject request from uid
          $st = $pdo->prepare('DELETE FROM friends WHERE `uid1`=:uid2 AND `uid2`=:uid1 AND `accepted`=0');
          $data = array(':uid1' => $user['uid'], ':uid2' => $uid);
          if (!$st->execute($data)) {
              $return['success'] = false;
          } else {
              $return['success'] = true;
          }
        break;
      case 'c': // cancel request to uid
          $st = $pdo->prepare('DELETE FROM friends WHERE `uid1`=:uid1 AND `uid2`=:uid2 AND `accepted`=0');
          $data = array(':uid1' => $user['uid'], ':uid2' => $uid);
          if (!$st->execute($data)) {
              $return['success'] = false;
          } else {
              $return['success'] = true;
          }
        break;
      case 'u': // unfriend user with uid
          $st = $pdo->prepare('DELETE FROM friends WHERE (`uid1`=:uid1 AND `uid2`=:uid2) OR (`uid1`=:uid2 AND `uid2`=:uid1)');
          $data = array(':uid1' => $user['uid'], ':uid2' => $uid);
          if (!$st->execute($data)) {
              $return['success'] = false;
          } else {
              $return['success'] = true;
          }
        break;
      case 's': // send request to uid
          $st = $pdo->prepare('INSERT INTO friends(`uid1`, `uid2`, `_time`) VALUES (:uid1, :uid2, NOW())');
          $data = array(':uid1' => $user['uid'], ':uid2' => $uid);
          if (!$st->execute($data)) {
              $return['success'] = false;
          } else {
              $return['success'] = true;
          }
        break;
      default:
        $return['success'] = false;
        break;
    }
} else {
    $return['success'] = false;
}
echo json_encode($return);
