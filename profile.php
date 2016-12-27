<!DOCTYPE html>
<html>
<body>
<?php
/*require_once 'user.php';
include_once 'db.php';

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $st = $pdo->prepare('SELECT * FROM user WHERE BINARY uid=:uid');
    if (!$st->execute(array(':uid' => $uid))) {
        throw new Exception('DB connection failed. (~UP)');
    } elseif ($st->rowCount() > 0) {
        $user = $st->fetch(PDO::FETCH_ASSOC);
    }
} elseif (is_logged()) {
    $user = $_SESSION['user'];
}

// for testing
echo implode('|', $user);*/
include_once 'hud.php';
?>
<link rel="stylesheet" href="css/profile.css">

<div class="img">
  <a target="_blank" href="image/no_profile_pic.jpg">
    <img src="no_profile_pic.jpg"  width="300" height="200">
  </a>
  <div class="addpp"><a href="#">add profile pic</a></div>
</div>

<div class="comment">
<textarea class='autosize' name="" id="" placeholder='what is on your mind?'></textarea>
     <button type="submit" name="postb"/>post</button>
   <textarea class='autosize' name="" id="" placeholder='Comment...'></textarea>
        <button type="submit" name="addb"/>add</button>
</div>
</body>
</html>
