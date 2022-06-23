<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/mail/join_mail.php");
foreach($_REQUEST as $key=>$val)
{                                                                                                                                                          
    $_REQUEST[$key] = htmlspecialchars(addslashes($val));
}
extract($_REQUEST);
//extract 보안
$data_arr = array('_SESSION', '_SERVER', 'COOKIE', '_FILES');
foreach($data_arr as $key){
    unset($_REQUEST[$key]);
}

$ck_id_query = "select * from user where user_id = '{$user_id}'";
$ck_id_result = sql_query($ck_id_query);
$ck_email_query = "select * from user where user_email = '{$user_email}'";
$ck_email_result = sql_query($ck_email_query);
$ck_id_result_row = sql_fetch($ck_id_result);
$user_name2 = $_REQUEST['user_name'];
$login_id = $ck_id_result_row['user_id'];
$musign_yn = $_REQUEST['musign_yn'];
$user_mail = $_REQUEST['user_email'];
$musign_yn = $_REQUEST['musign_yn'];


if(sql_count($ck_id_result) == 0 && sql_count($ck_email_result) == 0)
{
    $user_pw = hash("sha256", $_REQUEST['user_pw']);
    $query = "
        insert into user
        set
        user_id = '{$user_id}',
        user_pw = '{$user_pw}',
        user_co = '{$user_co}',
        user_name = '{$user_name}',
        user_phone = '{$user_phone}',
        user_email = '{$user_email}',
        server_name = '1',
        server_root = '',
        date_start = '',
        date_end = '',
        url = '',
        url_test = '',
        per_yn = 'N',
        pay_yn = 'N',
        login_count = '2',
        call_off_why = '',
        other_content = '',
        hope_date = '',
        hope_date2 = '',
        aws_cloud = '',
        musign_yn = '{$musign_yn}',
        submit_date = now()+0
        ";
//     echo $query;
//     exit;
    sql_query($query);
    ?>
    {
    	"isSuc":"success"
    }
<?php

}
else if(sql_count($ck_id_result) != 0)
{
    ?>
    {
    	"isSuc": "already_id",
    	"msg": "이미 사용중인 아이디입니다."
    }
	<?php
    exit;
}
else if(sql_count($ck_email_result) != 0){
    ?>
    {
    	"isSuc": "already_email",
    	"msg": "이미 사용중인 이메일입니다."
    }
    <?php 
    exit;
}

if ($musign_yn == "N") {
    // 뮤자인내 구축  X 체크시 musign_mail 전송
    musign_mail($user_name2,$user_mail);
} else {
    // 뮤자인내 구축  o 체크시 join_mail 전송
    join_mail($user_name2,$user_mail);
}
?>