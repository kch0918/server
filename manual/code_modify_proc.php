<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$title = htmlspecialchars(addslashes($_REQUEST['title']));
$css = htmlspecialchars(addslashes($_REQUEST['css']));
$html = htmlspecialchars(addslashes($_REQUEST['html']));
$script = htmlspecialchars(addslashes($_REQUEST['script']));
$back = htmlspecialchars(addslashes($_REQUEST['back']));

$query = "update code set title = '{$title}', css = '{$css}', html = '{$html}', script = '{$script}', back = '{$back}' where idx = {$_REQUEST['idx']}";

sql_query($query);
?>
{
	"isSuc":"success"
}
