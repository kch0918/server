<?php
header("Content-Type:text/html; charset=utf-8;");
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 
$idx = $_GET['idx'];
$goodsName = $_GET['$goodsName'];
$server_feature = $_GET['server_feature'];
$dump_col = $_GET['dump_col'];
$tid= $_GET['tid'];
$query = "select * from pay_result where idx = $idx";

//결제 취소시 update
$cancel_result_query = 
                       "
                        update pay_result set
                            cancle_yn ='Y',
                            use_yn='N',
                            cancle_cd='2001',
                            canceldate=now()+0,
                            chk_date = now()+0
                        where tid = '{$tid}'
                       ";

sql_query($cancel_result_query);


$result = sql_query($query);
$row = sql_fetch($result);

$merchantKey = "a9Mw0kcxO9/p6vqXJZg227dIbFIuLMD7AI/WlnBK8kPlG022KuOBdlnfCer8Ihh1+OPeB3KACSDpwYIifNY5sg==";
$mid = "musigner1m";
// $merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg==";
// $mid = "nicepay00m";
$moid = "nicepay_api_3.0_test";
$cancelMsg = "고객요청";
//$tid = $_POST['TID'];

$cancelAmt = $_GET['CancelAmt'];
$partialCancelCode = 0;
$ediDate = date("YmdHis");
$signData = bin2hex(hash('sha256', $mid . $cancelAmt . $ediDate . $merchantKey, true));

$resMsg = "";
try{
    $data = Array(
        'GoodsName' => $goodsName,
        'Server_feature' => $server_feature,
        'Dump_col' => $dump_col,
        'TID' => $tid,
        'MID' => $mid,
        'Moid' => $moid,
        'CancelAmt' => $cancelAmt,
        'CancelMsg' => iconv("UTF-8", "EUC-KR", $cancelMsg),
        'PartialCancelCode' => $partialCancelCode,
        'EdiDate' => $ediDate,
        'SignData' => $signData,
        'CharSet' => 'utf-8'
        );
    $response = reqPost($data, "https://webapi.nicepay.co.kr/webapi/cancel_process.jsp"); //취소 API 호출
    $respArr = json_decode($response);
    foreach ( $respArr as $key => $value ){
        if($key == "ResultMsg"){
            $resMsg = $value;
        }
    }
//     jsonRespDump($response);
    
}catch(Exception $e){
    $e->getMessage();
    $ResultCode = "9999";
    $ResultMsg = "통신실패";
}

// API CALL foreach 예시
function jsonRespDump($resp){
    $respArr = json_decode($resp);
    foreach ( $respArr as $key => $value ){
        if($key == "ResultMsg"){
            $resMsg = $value;
        }
        /* if($key == "Data"){
            echo decryptDump ($value, $merchantKey)."<br />";
         }else{
            echo "$key=". $value."<br />";
         } */
    }
}

//Post api call
function reqPost(Array $data, $url){
    $requestData = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded;charset=euc-kr"',
            'content' => http_build_query($data),
            'timeout' => 15
        )
    ));
    
    $response = file_get_contents($url, FALSE, $requestData);
    return $response;
}
?>

{
	"isSuc":"success",
	"msg":"<?php echo $resMsg?>"
}