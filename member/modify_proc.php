<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
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
$user_pw = hash("sha256", $_REQUEST['user_pw']);
$past_pw = hash("sha256", $_REQUEST['past_pw']);
$ck_query = "select * from user where user_id = '{$_SESSION['login_id']}' and user_pw = '{$past_pw}'";
$ck_result = sql_query($ck_query);

// 비밀번호 변경시 login_cnt를 한번더 ++ 해줌 
$count_query = "update user set login_count = `login_count`+1 where user_id = '{$_SESSION['login_id']}'";
$count_result = sql_query($count_query);
$count_row = sql_fetch($count_result);
$login_cnt = $count_row['login_count'];

if(sql_count($ck_result) == 1 || $_SESSION['login_id'] == "qwe123" || $_SESSION['login_id'] == "lsm")
{
    $login_cnt++;
    $query = "
        update user
        set
        user_pw = '{$user_pw}',
        user_co = '{$user_co}',
        user_name = '{$user_name}',
        user_phone = '{$user_phone}',
        user_email = '{$user_email}'
        where user_id = '{$_SESSION['login_id']}'
        ";
    if($_SESSION['login_id'] == 'qwe123' || $_SESSION['login_id'] == 'lsm' ){
    $query = "
        update user
        set
        user_co = '{$user_co}',
        user_name = '{$user_name}',
        user_phone = '{$user_phone}',
        user_email = '{$user_email}',
        server_name = '{$server_name}',
        server_root = '{$server_root}',
        date_start = '{$date_start}',
        date_end = '{$date_end}',
        url = '{$url}',
        url_test = '{$url_test}',
        aws_cloud = '{$aws_cloud}',
        per_yn = '{$per_yn}',
        pay_yn = '{$pay_yn}'
        where idx = '{$idx}'
        ";
    }
//     echo $query;
//     exit;
    sql_query($query);
    ?>
    {
    	"isSuc": "success",
    	"msg": "저장되었습니다."
    }
    <?php 
}
else
{
    ?>
    {
        "isSuc": "fail",
        "msg": "이전 정보가 일치하지 않습니다."
    }
    <?php
    exit;
}
?>