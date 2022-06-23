<?php
header("Content-Type:text/html; charset=utf-8;");

$merchantKey = "a9Mw0kcxO9/p6vqXJZg227dIbFIuLMD7AI/WlnBK8kPlG022KuOBdlnfCer8Ihh1+OPeB3KACSDpwYIifNY5sg==";
$mid = "musigner1m";
// $merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg==";
// $mid = "nicepay00m";
$moid = "nicepay_api_3.0_test";
$cancelMsg = "고객요청";
$tid = $_POST['TID'];
$cancelAmt = $_POST['CancelAmt'];
$partialCancelCode = $_POST['PartialCancelCode'];

$ediDate = date("YmdHis");
$signData = bin2hex(hash('sha256', $mid . $cancelAmt . $ediDate . $merchantKey, true));

try{
    $data = Array(
        'TID' => $tid,
        'MID' => $mid,
        'Moid' => $moid,
        'CancelAmt' => $cancelAmt,
        'CancelMsg' => $cancelMsg,
        'PartialCancelCode' => $partialCancelCode,
        'EdiDate' => $ediDate,
        'SignData' => $signData
        );
    $response = reqPost($data, "https://webapi.nicepay.co.kr/webapi/cancel_process.jsp"); //취소 API 호출
    jsonRespDump($response);
}catch(Exception $e){
    $e->getMessage();
    $ResultCode = "9999";
    $ResultMsg = "통신실패";
}

// API CALL foreach 예시
function jsonRespDump($resp){
    $resp_utf = iconv("EUC-KR", "UTF-8", $resp);
    $respArr = json_decode($resp_utf);
    foreach ( $respArr as $key => $value ){
        if($key == "Data"){
            echo decryptDump ($value, $merchantKey)."<br />";
        }else{
//             echo "$key=". iconv("UTF-8", "EUC-KR", $value)."<br />";
            echo "$key=". $value."<br />";
        }
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