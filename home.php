<link rel="stylesheet" href="css/form.css">
<script src="js/auth.js"></script>
<script src="js/form.js"></script>
<?php
 if (is_logged()) {
     include 'timeline.php';
 } else {
     include 'regform.php';
 }
