<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$title = htmlspecialchars(addslashes($_REQUEST['title']));
$css = htmlspecialchars(addslashes($_REQUEST['css']));
$html = htmlspecialchars(addslashes($_REQUEST['html']));
$script = htmlspecialchars(addslashes($_REQUEST['script']));
$back = htmlspecialchars(addslashes($_REQUEST['back']));

$query = "insert into code set title = '{$title}', css = '{$css}', html = '{$html}', script = '{$script}', back = '{$back}', submit_date = now()+0";

sql_query($query);
?>
{
	"isSuc":"success"
}
