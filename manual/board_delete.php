<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 

$idx = $_REQUEST['idx'];
$board = $_REQUEST['board'];

$query = "delete from {$_REQUEST['board']} where idx = {$_REQUEST['idx']}";
sql_query($query);
?>

{
	"isSuc":"success"
}