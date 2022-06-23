<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 

$query = "update manager
                set
                manager='{$_REQUEST['server']}'
                where cate = 'server'
         ";
sql_query($query);
$query = "update manager
                set
                manager='{$_REQUEST['godo']}'
                where cate = 'godo'
         ";
sql_query($query);
$query = "update manager
                set
                manager='{$_REQUEST['qa']}'
                where cate = 'qa'
         ";
sql_query($query);
$query = "update manager
                set
                manager='{$_REQUEST['account']}'
                where cate = 'account'
         ";
sql_query($query);
$query = "update manager
                set
                manager='{$_REQUEST['setting']}'
                where cate = 'setting'
         ";
sql_query($query);
$query = "update manager
                set
                manager='{$_REQUEST['error']}'
                where cate = 'error'
         ";
sql_query($query);
$query = "update manager
                set
                manager='{$_REQUEST['code']}'
                where cate = 'code'
         ";
sql_query($query);
$query = "update manager
                set
                manager='{$_REQUEST['manage_co']}'
                where cate = 'manage_co'
         ";
sql_query($query);
?>
{
	"isSuc":"success",
	"msg":"저장되었습니다."
}