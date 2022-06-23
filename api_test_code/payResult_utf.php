<?php
header("Content-Type:text/html; charset=utf-8;");
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 
require_once($_SERVER['DOCUMENT_ROOT']."/mail/pay_complete_mail.php"); 
/*
 ****************************************************************************************
 * <인증 결과 파라미터>
 ****************************************************************************************
 */
$authResultCode =  $_POST['AuthResultCode'];		// 인증결과 : 0000(성공)
$authResultMsg  =  $_POST['AuthResultMsg'];		    // 인증결과 메시지
$nextAppURL     =  $_POST['NextAppURL'];			// 승인 요청 URL
$txTid          =  $_POST['TxTid'];					// 거래 ID
$authToken      =  $_POST['AuthToken'];				// 인증 TOKEN
$payMethod      =  $_POST['PayMethod'];				// 결제수단
$mid            =  $_POST['MID'];					// 상점 아이디
$moid           =  $_POST['Moid'];					// 상점 주문번호
$amt            =  $_POST['Amt'];					// 결제 금액
$reqReserved    =  $_POST['ReqReserved'];			// 상점 예약필드
$netCancelURL   =  $_POST['NetCancelURL'];			// 망취소 요청 URL
$chk_year       =  $_POST['chk_year'];              // 구매 기간
$buyername      =  $_POST['BuyerName'];             // 구매자이름
$goodsname      =  $_POST['GoodsName'];             // 구매상품명


$token_query = "update user set tid ='{$txTid}', auth_token = '{$authToken}' where idx={$_SESSION['idx']}";
sql_query($token_query);

//결재시 pay_result 테이블에 추가
$add_pay_result_query ="insert into pay_result set 
                            user_idx='{$_SESSION['idx']}',
                            tid ='{$txTid}',
                            paymethod='{$payMethod}',
                            mid='{$mid}',
                            amt='{$amt}',
                            name = '{$buyername}',
                            goodsname = '{$goodsname}',
                            moid='{$moid}',
                            chk_year = '{$chk_year}', 
                            auth_token ='{$authToken}',
                            submit_date = now()+0 ";

sql_query($add_pay_result_query);

/*
 ****************************************************************************************
 * <승인 결과 파라미터 정의>
 * 샘플페이지에서는 승인 결과 파라미터 중 일부만 예시되어 있으며,
 * 추가적으로 사용하실 파라미터는 연동메뉴얼을 참고하세요.
 ****************************************************************************************
 */

$response = "";

if($authResultCode === "0000"){
    /*
     ****************************************************************************************
     * <해쉬암호화> (수정하지 마세요)
     * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
     ****************************************************************************************
     */
    $ediDate = date("YmdHis");
//  $merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
    $merchantKey = "a9Mw0kcxO9/p6vqXJZg227dIbFIuLMD7AI/WlnBK8kPlG022KuOBdlnfCer8Ihh1+OPeB3KACSDpwYIifNY5sg=="; // 상점키
    $signData = bin2hex(hash('sha256', $authToken . $mid . $amt . $ediDate . $merchantKey, true));
    
    try{
        $data = Array(
            'TID' => $txTid,
            'AuthToken' => $authToken,
            'MID' => $mid,
            'Amt' => $amt,
            'EdiDate' => $ediDate,
            'SignData' => $signData,
            'CharSet' => 'utf-8',
            );
        
        $response = reqPost($data, $nextAppURL); //승인 호출
        jsonRespDump($response); //response json dump example
        
    }catch(Exception $e){
        $e->getMessage();
        $data = Array(
            'TID' => $txTid,
            'AuthToken' => $authToken,
            'MID' => $mid,
            'Amt' => $amt,
            'EdiDate' => $ediDate,
            'SignData' => $signData,
            'NetCancel' => '1',
            'CharSet' => 'utf-8',
            );
        
        $response = reqPost($data, $netCancelURL); //예외 발생시 망취소 진행
        jsonRespDump($response); //response json dump example
        pay_complete_mail(); // 결제완료 이메일 
    }
    
}else{
    //인증 실패 하는 경우 결과코드, 메시지
    $ResultCode = $authResultCode;
    $ResultMsg = $authResultMsg;
}

// API CALL foreach 예시
function jsonRespDump($resp){
    
  //  $respArr = json_decode($resp);
    
    
    echo $resp;
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
    echo $response;
}
?>