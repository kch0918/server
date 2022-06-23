<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 

$query = "select * from user where user_id='{$_SESSION['login_id']}'";
$result = sql_query($query);
$row = sql_fetch($result);

$server_info_query="select * from server_info where server_type = '{$row['server_name']}'";
$server_info_result =sql_query($server_info_query);
$server_info_row = sql_fetch($server_info_result);


$merchantKey = "a9Mw0kcxO9/p6vqXJZg227dIbFIuLMD7AI/WlnBK8kPlG022KuOBdlnfCer8Ihh1+OPeB3KACSDpwYIifNY5sg==";
$MID = "musigner1m";
// $merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
// $MID         = "nicepay00m"; // 상점아이디
$price = "{$_POST['server_price']}";
$goodsName   = "{$row['server_name']}"; // 결제상품명
$buyerName   = "{$row['user_name']}"; // 구매자명
$buyerTel	 = "{$row['user_phone']}"; // 구매자연락처
$buyerEmail  = "{$row['user_email']}"; // 구매자메일주소
$moid        = "{$server_info_row['idx']}"; // 상품주문번호
$returnURL	 = $_SERVER['DOCUMENT_ROOT']."/api_test_code/payResult_utf.php";



// $server_price = base64_decode($_POST['server_price']);
// $merchantKey = base64_decode($_POST['merchantKey']);
// $MID = base64_decode($_POST['MID']);
// $goodsName = base64_decode($_POST['goodsName']);
// $buyerName = base64_decode($_POST['buyerName']);
// $buyerTel = base64_decode($_POST['buyerTel']);
// $buyerEmail = base64_decode($_POST['buyerEmail']);
// $moid = base64_decode($_POST['moid']);
// $returnURL = base64_decode($_POST['returnURL']);

$ediDate = date("YmdHis");
$hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));

echo $hashString.'@'.$ediDate;
?>