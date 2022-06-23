<?php 
if($_SESSION['manager_yn'] !== "Y")
{
    alert('잘못된 접근입니다.');
    href('/');
}
?>