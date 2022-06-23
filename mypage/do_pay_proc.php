<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 

$pay_check = htmlspecialchars(addslashes($_POST['pay_check']));
$query = "update user
                set
                pay_yn='{$pay_check}'
                where user_id = '{$_SESSION['login_id']}'
         ";

sql_query($query);
?>
{
	"isSuc":"success",
	"msg":"저장되었습니다."
}