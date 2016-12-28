<?php

include_once 'user.php';
include_once 'db.php';
$return = array();
if (is_logged() && isset($_POST['t']) && isset($_POST['puid']) && isset($_POST['pid']) && (isset($_POST['cid']) || $_POST['t'] = 'p')) {
    $puid = $_POST['puid'];
    $pid = $_POST['pid'];
    $user = get_user();
    if ($_POST['t'] == 'p') {
        $st = $pdo->prepare('INSERT INTO likes_post(`uid`, `puid`, `pid`) VALUES (:uid, :puid, :pid)');
        $data = array(':uid' => $user['uid'], ':puid' => $puid, ':pid' => $pid);
        if (!$st->execute($data)) {
            $return['success'] = false;
        } else {
            $return['success'] = true;
            create_notf_likepost($puid, $pid, $pdo);
        }
    } else {
        $cid = $_POST['cid'];
        $st = $pdo->prepare('INSERT INTO likes_comment(`uid`, `puid`, `pid`, `cid`) VALUES (:uid, :puid, :pid, :cid)');
        $data = array(':uid' => $user['uid'], ':puid' => $puid, ':pid' => $pid, ':cid' => $cid);
        if (!$st->execute($data)) {
            $return['success'] = false;
        } else {
            $return['success'] = true;
            create_notf_likecomment($puid, $pid, $cid, $pdo);
        }
    }
} else {
    $return['success'] = false;
}
echo json_encode($return);
