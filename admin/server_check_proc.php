<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$idx = $_REQUEST['idx'];

$server_name     =   $_REQUEST['server_name'];
$user_name       =   $_REQUEST['user_name'];
$ip              =   $_REQUEST['ip'];
$volume_chk      =   $_REQUEST['volume_chk'];
$volume_cmt      =   $_REQUEST['volume_cmt'];
$share_chk       =   $_REQUEST['share_chk'];
$share_cmt       =   $_REQUEST['share_cmt'];
$log_chk         =   $_REQUEST['log_chk'];
$log_cmt         =   $_REQUEST['log_cmt'];
$submit_date     =   $_REQUEST['submit_date'];
$user_id         =   $_SESSION['login_id'];

$query = "
            update server_checklist 
                    set
                    server_name = '{$server_name}',
                    user_name   = '{$user_name}',
                    ip          = '{$ip}',
                    volume_chk  = '{$volume_chk}',
                    volume_cmt  = '{$volume_cmt}',
                    share_chk   = '{$share_chk}',
                    share_cmt   = '{$share_cmt}',
                    log_chk     = '{$log_chk}',
                    log_cmt     = '{$log_cmt}',
                    submit_date = '{$submit_date}',
                    user_id     = '{$user_id}'
                    where idx = '{$idx}'                    
           ";
sql_query($query);

?>
{
	"isSuc":"success",
	"msg"  :"저장되었습니다."
}

