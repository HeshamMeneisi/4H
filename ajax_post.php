<?php
include_once 'user.php';
include_once 'db.php';

    $caption=$_POST['caption'];
    if (isset($_POST['image'])){
        $image = $_POST['image'];
    }
    if(!$_POST['privacy']){
        $privacy = false;
    }
    else{
        $privacy = true;
    }
    $user = get_user();
    $post_status = $pdo->prepare('INSERT INTO post(`puid`, `caption`, `privacy`, `ptime`) VALUES (:puid, :caption, :privacy,NOW())');
    $post_insert_data = array(':puid' =>$user['uid'],':caption' => $caption,':privacy' => $privacy);
    if (!$post_status->execute($post_insert_data)) {
        echo "Failed to post";
    } else{
        echo "Posted";
    }
?>
