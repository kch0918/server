<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$title = htmlspecialchars(addslashes($_REQUEST['title']));

$query = "update {$_REQUEST['board']} set title = '{$title}', content = '{$_REQUEST['contents']}' where idx = {$_REQUEST['idx']}";

sql_query($query);
?>
{
	"isSuc":"success"
}
