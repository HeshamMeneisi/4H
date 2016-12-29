<link rel="stylesheet" href="css/form.css">
<script src="js/auth.js"></script>
<script src="js/form.js"></script>
<?php
 if (is_logged()) {
     include_once core.php;
     $name = get_user()['nickname'];
     echo '<h1 class="page_title">Howdy, '.$name.'!</h1>';
     include 'timeline.php';
 } else {
     include 'regform.php';
 }
