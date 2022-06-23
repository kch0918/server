<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$title = htmlspecialchars(addslashes($_REQUEST['title']));

$query = "insert into {$_REQUEST['board']} set title = '{$title}', content = '{$_REQUEST['contents']}', submit_date = now()+0";

sql_query($query);
?>
{
	"isSuc":"success"
}
