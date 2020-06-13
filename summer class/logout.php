<?php
session_start();
$_SESSION["logout"] = 'true';
unset($_SESSION["login"]);
header("Location: ccc.php");
exit;
?>
