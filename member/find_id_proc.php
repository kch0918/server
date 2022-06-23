<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/mail/send_mail.php");

$find_email= htmlspecialchars(addslashes($_REQUEST['user_email']));

$ck_query = "select * from user where user_email = '{$find_email}'";
$ck_result = sql_query($ck_query);
$row = sql_fetch($ck_result);
if(sql_count($ck_result) == 1)
{
    $user_id = $row['user_id'];
    $user_email = $row['user_email'];
    send_id_mail($user_email, $user_id);
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
    	"isSuc": "no_email",
    	"msg": "존재하지 않는 이메일입니다."
    }
	<?php
    exit;
}
?>