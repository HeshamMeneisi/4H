<head>
<link rel="stylesheet" href="css/hud.css">
<link rel="stylesheet" href="css/form.css">
<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
<link rel="stylesheet" href="css/profile.css">
<script src="js/auth.js"></script>
<script src="js/form.js"></script>
<script src="js/picture.js"></script>
<script src="js/jquery-3.1.1.js"></script>
</head>
<div class='uhud'>
<?php
require_once 'user.php';
if (is_logged()):
  include 'userhud.php';
else:
  include 'loginform.php';
endif
?>
</div>
