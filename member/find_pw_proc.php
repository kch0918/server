<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/function.php");
require_once($_SERVER['DOCUMENT_ROOT']."/mail/send_mail.php");

$find_id = htmlspecialchars(addslashes($_REQUEST['user_id']));
$find_email = htmlspecialchars(addslashes($_REQUEST['user_email']));

$ck_query = "select * from user where user_id = '{$find_id}' and user_email = '{$find_email}'";
$ck_result = sql_query($ck_query);
$row = sql_fetch($ck_result);
if(sql_count($ck_result) == 1)
{
    $user_email = $row['user_email'];
    $temp_pw = generateRandomString(10);
    $user_pw = hash("sha256", $temp_pw);
    $query = "update user set user_pw = '{$user_pw}' where user_id = '{$find_id}' and user_email = '{$find_email}'";
    sql_query($query);
    send_pw_mail($user_email, $temp_pw);
    ?>
    {
    	"isSuc":"success"
    }
<?php
}
else
{
    ?>
    {
    	"isSuc": "no_info",
    	"msg": "일치하는 계정이 없습니다."
    }
	<?php
    exit;
}
?>