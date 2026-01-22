<?php
session_start();
include('connection.php');
unset($_SESSION['email']);
session_destroy();

header("Location: index.php");
exit;
?>