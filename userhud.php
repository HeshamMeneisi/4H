<?php
include_once 'user.php';

?>
<?php
    if (isset($_GET['p'])) {
        echo '<ul class="navbar-p">';
    } else {
        echo '<ul class="navbar">';
    }
?>
  <li><form method="get" action="search.php" id="search">
    <input type="hidden" name="mode" value="q">
    <input name="query" type="text" size="40" placeholder="Search..." />
  </form>
  </li>
  <li><a href="index.php">Home</a></li>
    <li class="notify-btn"><a href="#">Notifications<span class="notify pink">2</span></a></li>
    <?php if (isset($_GET['p'])): ?>
  <li><a href="#">Edit Info</a></li>
  <li><a href="friends.php">Friends</a></li>
  <li><a href="#">About</a></li>
  <?php else:
    $nickname = get_user()['nickname'];
  echo "<li><a href='./profile.php'>{$nickname}</a></li>";
  endif; ?>
  <li><a href='./auth.php?op=x'>Logout</a></li>
</ul>
