<!DOCTYPE html>
<html>

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
?>
<head>
<link rel="stylesheet" href="css/profile.css"></head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<header>
<ul class="nav">
  <li><a href="home.php">Home</a></li>
  <li><a href="#">Edit information</a></li>
  <li><a href="friends.php">Friends</a></li>
  <li><a href="#">notification<span class="notify pink">2</span></a>
  <li><a href="#">About</a></li>
   <li style="float:right"><a href="#">log out</a></li>
  <li><form method="get" action="search.php" id="search">
   <input name="sr" type="text" size="40" placeholder="Search..." />
  </form>
  </li>
</ul>
</header>
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

</html>