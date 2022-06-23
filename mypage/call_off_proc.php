<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/function.php");
require_once($_SERVER['DOCUMENT_ROOT']."/mail/call_off_mail.php");

$result     =  "select * from user";
$result     =  sql_query($result);
$row        =  sql_fetch($result);
$user_name  =  $row['user_name'];
$content2 = $_REQUEST['other_content2'];

$call_off      =  $_REQUEST['customizedValue1'];
$content       =  $_REQUEST['my_content'];

$query = 
          "
            update user set
            call_off_why  = '{$call_off}',
            other_content = '{$content}',
            other_content2 = '{$content2}'
            where user_id  = '{$_SESSION['login_id']}'
          ";

sql_query($query);

call_off_mail($user_name);
?>
    {
        "isSuc": "success",
        "msg"  : "해지 신청 접수 완료되었습니다."
    }
