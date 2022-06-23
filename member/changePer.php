<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$idx = $_REQUEST['idx'];
$per_yn = $_REQUEST['per_yn'];

$query = "update user set per_yn = '{$per_yn}' where idx = {$idx}";

sql_query($query);
    ?>
    {
    	"isSuc": "success",
    	"msg": "저장되었습니다."
    }
