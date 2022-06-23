<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/function.php");
require_once($_SERVER['DOCUMENT_ROOT']."/mail/call_move_mail.php");

$result = "select * from user";
$result = sql_query($result);
$row = sql_fetch($result);
$user_name = $row['user_name'];
$user_email = $row['user_email'];

$call_off = $_REQUEST['customizedValue2'];
$content2 = $_REQUEST['other_content2'];
$content = $_REQUEST['my_content'];
$hope_date = $_REQUEST['hope_date'];
$hope_date2 = $_REQUEST['hope_date2'];

$query = "
            update user set
            call_off_why   = '{$call_off}',
            other_content  = '{$content}',
            other_content2 = '{$content2}',
            hope_date      = '{$hope_date}',
            hope_date2      = '{$hope_date2}'
            where user_id  = '{$_SESSION['login_id']}'
          ";

sql_query($query);

call_move_mail($user_name,$user_email);

$ck_query = "select * from user where user_name = '{$user_name}'";
$ck_result = sql_query($ck_query);

if(sql_count($ck_result) == 1) {
    // 성공시 메일    
?>
    {
        "isSuc":"success",
        "msg":"해지/이전 신청 접수 완료되었습니다. 이전비용을 결제해주세요."
    }
<?php 
  
} else {
?> 
	{
        "isSuc":"fail",
        "msg":"담당자에게 문의바랍니다."
    }
<?php 
    exit;
}
?>