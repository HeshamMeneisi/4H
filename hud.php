<link rel="stylesheet" href="css/hud.css">
<link rel="stylesheet" href="css/form.css">
<script src="js/auth.js"></script>
<script src="js/form.js"></script>
<div class='uhud'>
<?php
require_once 'user.php';
if (is_logged()):
  echo "<label>Welcome {$_SESSION['user']['nickname']}!</label>";
?>
  <button id="lobtn" class='sbtn' onclick='document.location="auth.php?op=x"'>Logout</button>
<?php
else:
  include 'loginform.php';
endif
?>
</div>
