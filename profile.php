<!DOCTYPE html>
<html>
<body>
<container id="profilecontainer">
<?php
require_once 'user.php';
include_once 'db.php';
if (!is_logged()) {
    header('Location: index.php');
    exit;
}
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $st = $pdo->prepare('SELECT * FROM user WHERE BINARY uid=:uid');
    if (!$st->execute(array(':uid' => $uid))) {
        throw new Exception('DB connection failed. (~UP)');
    } elseif ($st->rowCount() > 0) {
        $user = $st->fetch(PDO::FETCH_ASSOC);
    }
} elseif (is_logged()) {
    $user = get_user();
    $uid = $user['uid'];
}

$pic = 'image/pic_'.$uid.'.png';
$nopic = false;
if (!file_exists($pic)) {
    $pic = "./image/def_{$user['gender']}.jpg";
    $nopic = true;
}

// for testing
// echo implode('|', $user);
$_GET['p'] = 1;
include_once 'hud.php';
?>
<div id="pheadcontainer">
<div class='profile-head'>
<div class="name">
  <?php echo $user['fname'].' '.$user['lname']; ?>
</div>
<div class="nickname-p">
  <?php echo '('.$user['nickname'].')'; ?>
</div>

<div class="profile-picture">
<table id="pp">
<tr>
    <td>
<?php
    if (!is_friend($uid, $pdo)) {
        echo "<button class='friend_button' onclick='send_freq({$uid})'>Add friend</button>";
    } elseif ($uid != get_user()['uid']) {
        echo "<button class='friend_button' onclick='unfriend({$uid})'>Remove friend</button>";
    }

?>
    </td>
    <td>
    <img src=<?php echo $pic; ?> />
    </td>
    <td id="pp-upload">
    <?php if ($nopic):?>
    <input type="button" id="EditButton" value="Edit" onclick="show_upload()" />
    <div id="uploadSection">
    <form action="picture.php" method="post" enctype="multipart/form-data">
    <input type="file" name="uploaded_image" id="fileToUpload" class="hidden">
    <input type="submit" value="Add Avatar" name="submit">
    </form>
    </div>
    <?php else:?>
    <input type="button" id="EditButton" value="Edit" onclick="show_upload()" />
    <div id="uploadSection">
    <form action="picture.php" method="post" enctype="multipart/form-data">
    <input type="file" name="uploaded_image" id="fileToUpload" class="hidden">
    <input type="submit" value="Update Avatar" name="submit">
    </form>
    </div>
    <?php endif; ?>
    </td>

</tr>
</table>
</div>

<?php
    if ($user['about']) {
        echo '<p id="label">Bio</p><br/>'.'<div id="bio">'.$user['about'].'</div>';
    }
    if ($user['bdate']) {
        echo '<br/><p id="label">Birthday: '.date('j F', strtotime($user['bdate'])).'</p>';
    }
    if ($user['email']) {
        echo '<br/><br/><p id="label">Email: '.$user['email'].'</p>';
    }
    $location = fetch_loc($user['uid'], $pdo);
    if ($location) {
        echo '<br/><br/><p id="label">Location: '.$location['city'].'</p>';
    }
    $phone = fetch_phones($user['uid'], $pdo);
    if ($phone) {
        echo '<br/><br/><p id="label">Phone: '.$phone['phone'].'</p>';
    }
?>
</div>
<hr>
</div>
<?php
$_GET['p'] = 1;
include 'timeline.php';
?>
</container>
</body>
</html>
