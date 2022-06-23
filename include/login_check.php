<?php 
if($_SESSION['login_id'] == "" || !isset($_SESSION['login_id']))
{
    alert('잘못된 접근입니다.');
    href('/');
}
?>