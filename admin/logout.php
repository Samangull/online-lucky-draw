<?php
session_start();
include('db.php');
unset($_SESSION['email']);
session_destroy();

header("Location: ../index.php");
exit;
?>