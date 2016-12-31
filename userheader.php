<script src="js/updater.js"></script>
<?php
   include_once 'core.php';

   include_once 'db.php';

   ?>
<a href="../"><img class="logo" src="files/logo.png" alt="Hallo"/></a>
<?php
   if (isset($_GET['p'])) {
       echo '<ul class="navbar-p">';
   } else {
       echo '<ul class="navbar">';
   }
   ?>
<li>
   <form method="get" action="search.php" id="search">
      <input type="hidden" name="mode" value="q">
      <input name="query" type="text" size="40" placeholder="Search" />
   </form>
</li>
<li><a href="./">Home</a></li>
<li class="notify-btn"><a href="notifications">Notifications<span id="ncounter" class="notify notification_counter"><?php
   echo count_unseen_notf($pdo) ?></span></a></li>
<?php
   if (isset($_GET['p'])): ?>
<li><a href="settings">Settings</a></li>
<li><a href="friends.php?r=1&l=1">Friends</a></li>
<?php
   else:
    $nickname = get_user() ['nickname'];
    echo "<li><a href='./profile'>{$nickname}</a></li>";
   endif; ?>
<li><a href='./auth?op=x'>Logout</a></li>
</ul>
