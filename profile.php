<html>
<head><link rel="stylesheet" href="css/profile.css">
</head>
<body>
<container id="profilecontainer">
<?php
require_once 'core.php';
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
if ($uid == get_user()['uid']){
    echo '<title>Profile - Hallo</title>';
}
else{
    echo '<title>'.$user['nickname'].' - Hallo</title>';
}
$pic = 'content/users/'.$uid.'/profile_picture.png';
$nopic = false;
if (!file_exists($pic)) {
    $pic = "./content/static/default_picture/{$user['gender']}.jpg";
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
    <img src=<?php echo $pic; ?> />
    </tr>
    <tr id="pp-upload">
    <?php if ($nopic):?>
    <?php if ($uid == get_user()['uid']):?>
    <input type="button" id="EditButton" value="Edit" onclick="show_upload()" />
    <?php endif; ?>
    <div id="uploadSection">
    <form action="picture.php" method="post" enctype="multipart/form-data">
    <input type="file" name="uploaded_image" id="fileToUpload">
    <input type="submit" value="Add Avatar" name="submit">
    </form>
    </div>
    <?php else:?>
    <?php if ($uid == get_user()['uid']):?>
    <input type="button" id="EditButton" value="Edit" onclick="show_upload()" />
    <?php endif; ?>
    <div id="uploadSection">
    <form id="uploadSection" action="picture.php" method="post" enctype="multipart/form-data">
    <input type="file" name="uploaded_image" id="fileToUpload">
    <input type="submit" value="Update Avatar" name="submit">
    </form>
    </div>
    <?php endif; ?>
    </tr>
<?php
    $fs = get_friend_state($uid, $pdo);
    switch ($fs) {
      case 1:
          echo "<button class='friend_button' onclick='unfriend({$uid})'>Unfriend</button>"; break;
      case 2: // request pending
          echo 'Pending request.'; break;
      case 3: // request exists
          echo "<button class='friend_button' onclick='accept_freq({$uid})'>Accept</button>";
          echo "<button class='friend_button' onclick='reject_freq({$uid})'>Reject</button>"; break;
        break;
      case 4: // not friends
          echo "<button class='friend_button' onclick='send_freq({$uid})'>Add friend</button>"; break;
        break;
    }

?>
</tr>

</table>
</div>

<?php
    if ($user['about']) {
        echo '<br/><p id="label">Bio</p><br/>'.'<div id="bio">'.$user['about'].'</div>';
    }
    echo '<div id="profile_info">';
    if ($user['bdate']) {
        echo '<br/><p id="label">Birthday:</p> <p id="info_content">'.date('j F', strtotime($user['bdate']));
    }
    if ($user['email']) {
        echo '<br/><br/><p id="label">Email:</p> <p id="info_content">'.$user['email'].'</p>';
    }
    $location = fetch_loc($user['uid'], $pdo);
    if ($location) {
        echo '<br/><br/><p id="label">Location:</p> <p id="info_content">'.$location['city'].'</p>';
    }
    $phone = fetch_phones($user['uid'], $pdo);
    if ($phone) {
        echo '<br/><br/><p id="label">Phone:</p> <p id="info_content">'.$phone['phone'].'</p>';
    }
    echo '</div>';
?>
</div>
</div>
<?php
$_GET['p'] = 1;
include 'timeline.php';
?>
</container>
</body>
</html>
