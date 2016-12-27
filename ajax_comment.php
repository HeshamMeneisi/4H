<?php

include_once 'user.php';
include_once 'db.php';

    $return = array();

    if (isset($_POST['puid']) && isset($_POST['pid']) && isset($_POST['caption'])) {
        $puid = $_POST['puid'];
        $pid = $_POST['pid'];
        $caption = $_POST['caption'];
    } else {
        $return['success'] = false;
        echo json_encode($return);
        die();
    }

    $user = get_user();
    $post_status = $pdo->prepare('INSERT INTO comment(`cuid`, `puid`, `pid`, `caption`, `ptime`) VALUES (:cuid, :puid, :pid, :caption, NOW())');
    $post_insert_data = array(
      ':cuid' => $user['uid'],
      ':puid' => $puid,
      ':pid' => $pid,
      ':caption' => $caption, );
    if (!$post_status->execute($post_insert_data)) {
        $return['success'] = false;
    } else {
        $return['success'] = true;
    }
    echo json_encode($return);
