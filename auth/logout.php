<?php
session_start();
session_destroy();
unset($_SESSION['token']);
unset($_SESSION['login_time']);
header("location:../index.php");
?>