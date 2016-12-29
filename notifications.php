<!-- retrieve top user notifications and display them in chronological order -->

<?php
include_once 'hud.php';
include_once 'db.php';
$notf = fetch_notf($pdo);
if ($notf) {
    echo '<h1 class="page_title">Notifications</h1>';
    echo '<div class="notifications_container">';
    foreach ($notf as $nf) {
        switch ($nf['type']) {
           case 0: // add
             $_GET['n'] = $nf['nickname'];
             $_GET['c'] = ' sent you a friend request!';
             $_GET['l'] = './friends.php?r=1&l=1';
             include 'notification.php';
             break;
           case 1: // accept
             $_GET['n'] = $nf['nickname'];
             $_GET['c'] = ' accepted your friend request!';
             $_GET['l'] = './profile.php?uid='.$nf['iuid'];
             include 'notification.php';
             break;
           case 2: // comment
             $_GET['n'] = $nf['nickname'];
             $_GET['c'] = ' commented on your post.';
             $_GET['l'] = "./post.php?mode=v&puid={$nf['uid']}&id={$nf['pid']}";
             include 'notification.php';
             break;
           case 3: // like post
             $_GET['n'] = $nf['nickname'];
             $_GET['c'] = ' liked your post.';
             $_GET['l'] = "./post.php?mode=v&puid={$nf['uid']}&id={$nf['pid']}";
             include 'notification.php';
             break;
             break;
           case 4: // like comment
             $_GET['n'] = $nf['nickname'];
             $_GET['c'] = ' liked your comment on a post.';
             $_GET['l'] = "./post.php?mode=v&puid={$nf['cpuid']}&id={$nf['pid']}";
             include 'notification.php';
             break;
             break;
         }
        mark_all_notf($pdo);
    }
echo '</div>';
}
else{
    echo '<div class="notifications_container"><h1>You have no notifications.</h1></div>';
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
