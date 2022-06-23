<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 

$server_type = htmlspecialchars(addslashes($_POST['server_type']));
$server_price1 = htmlspecialchars(addslashes($_POST['server_price']));
$server_feature_arr = htmlspecialchars(addslashes($_POST['server_feature_arr']));
$idx = htmlspecialchars(addslashes($_POST['server_idx']));

$server_price = preg_replace("/[^0-9]/", "",$server_price1);

$query = "update server_info
                set
                server_type='{$server_type}',
                server_price='{$server_price}',
                server_feature='{$server_feature_arr}'
                where idx={$idx}
         ";

sql_query($query);
?>
{
	"isSuc":"success",
	"msg":"저장되었습니다."
}