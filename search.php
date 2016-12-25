<!-- should support default query mode and advanced search mode $_GET['mode'] = {'q','a'} -->
<?php
if ($_GET['mode'] == 'q') {
    // use $_GET['query']
} else {
    // use advaned search values supplied from searchform.php
}
