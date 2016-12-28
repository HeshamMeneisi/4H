<!-- retrieve top user notifications and display them in chronological order -->

<?php
include_once 'hud.php';
include_once 'db.php';

$notf = fetch_notf($pdo);
if ($notf) {
    foreach ($notf as $nf) {
        switch ($nf['type']) {
           case 0: // add
             $_GET['c'] = $nf['nickname'].' sent you an add request!';
             $_GET['l'] = './friends.php?r=1&l=1';
             include 'notification.php';
             break;
           case 1: // accept
             $_GET['c'] = $nf['nickname'].' accepted your add request!';
             $_GET['l'] = './profile.php?uid='.$nf['iuid'];
             include 'notification.php';
             break;
           case 2: // comment
             $_GET['c'] = $nf['nickname'].' commented on your post.';
             $_GET['l'] = "./post.php?mode=v&puid={$nf['uid']}&id={$nf['pid']}";
             include 'notification.php';
             break;
           case 3: // like post
             $_GET['c'] = $nf['nickname'].' liked your post.';
             $_GET['l'] = "./post.php?mode=v&puid={$nf['uid']}&id={$nf['pid']}";
             include 'notification.php';
             break;
             break;
           case 4: // like comment
             $_GET['c'] = $nf['nickname'].' liked your comment on a post.';
             $_GET['l'] = "./post.php?mode=v&puid={$nf['cpuid']}&id={$nf['pid']}";
             include 'notification.php';
             break;
             break;
         }
        mark_all_notf($pdo);
    }
}

function fetch_notf($pdo)
{
    $uid = get_user()['uid'];
    $st = $pdo->prepare('SELECT notification.*, nickname FROM notification INNER JOIN user ON user.uid=iuid WHERE notification.uid=:uid ORDER BY _time DESC');
    if (!$st->execute(array(
    ':uid' => $uid,
  ))) {
        throw new Exception('DB connection failed.');
    } elseif ($st->rowCount() > 0) {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}
