<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 

$idx = $_REQUEST['idx'];

if($idx != null ) {
$query = 
         "
            INSERT INTO server_checklist
              (
                user_name, server_name, ip, volume_chk,
                volume_cmt, share_chk, share_cmt, log_chk, log_cmt,
                submit_date
              )
            SELECT
               '{$_SESSION['login_name']}', server_name, ip, volume_chk,
               volume_cmt, share_chk, share_cmt, log_chk, log_cmt,
               DATE_FORMAT(NOW(),'%Y%m%d')
            FROM server_checklist WHERE idx = $idx 
          ";

sql_query($query);
?>
{
	"isSuc":"success",
	"msg":"저장되었습니다."
}
<?php 
} else {
?>
{
	"isSuc":"fail",
	"msg":"항목을 체크해주세요."
}
<?php
    exit();
}
?>