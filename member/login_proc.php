<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$login_pw = hash("sha256", $_REQUEST['login_pw']);

$login_id = htmlspecialchars(addslashes($_REQUEST['login_id'])); 
$query = "select * from user where user_pw = '{$login_pw}' and user_id = '{$login_id}'";
$result = sql_query($query);
$row = sql_fetch($result);



$count_query = "update user set login_count = `login_count`+1 where user_id = '{$login_id}'";


if (sql_count($result) > 0)
{
    sql_query($count_query);
    if($row['per_yn'] == "Y")
    {
        $_SESSION['idx'] = $row['idx'];
        $_SESSION['login_id'] = $login_id;
        $_SESSION['login_co'] = $row['user_co'];
        $_SESSION['login_name'] = $row['user_name'];
        $_SESSION['manager_yn'] = $row['manager_yn'];
        $_SESSION['musign_yn'] = $row['musign_yn'];
        
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
        	"isSuc":"fail",
        	"msg":"아직 승인되지않았습니다.\n관리자에게 문의해주세요."
        }
        <?php
    }
}
else
{
    ?>
    {
    	"isSuc":"fail",
    	"msg":"아이디/비밀번호를 확인해주세요."
    }
    <?php
}

