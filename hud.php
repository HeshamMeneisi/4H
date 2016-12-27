<link rel="stylesheet" href="css/hud.css">
<link rel="stylesheet" href="css/form.css">
<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
<script src="js/auth.js"></script>
<script src="js/form.js"></script>
<div class='uhud'>
<a href="../"><img class="logo" src="files/logo.png" alt="Socio"/></a>
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
