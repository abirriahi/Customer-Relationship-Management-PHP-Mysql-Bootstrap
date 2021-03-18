<?php
session_start();
$_SESSION = array();
unset($_SESSION['loginadmin']);
header("location:../index.php");
?>