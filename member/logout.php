<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
session_destroy(); 
echo "<script>location.replace('/member/login.php');</script>";
?>