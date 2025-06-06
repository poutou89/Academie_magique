<?php session_start() ?>
<?php ob_start() ?>
<?php session_destroy();
 session_reset();
 header("Location: index.php"); ?>