<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$title = htmlspecialchars(addslashes($_REQUEST['no_title']));
$content = htmlspecialchars(addslashes($_REQUEST['no_content']));
$board_type = $_REQUEST['board_type'];

$query = "update notice set 
            title = '{$title}', 
            content = '{$content}',
            board_type = '{$board_type}'
            where idx = {$_REQUEST['idx']}";

sql_query($query);
?>
{
	"isSuc":"success"
}
