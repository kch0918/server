<?php
/*
================================================================================================
바로빌 팩스전송 연동서비스
version : 1.2 (2015-10)
		 
바로빌 연동개발지원 사이트
http://dev.barobill.co.kr/
'================================================================================================
*/

//바로빌 연동서비스 웹서비스 참조(WebService Reference) URL	
$BaroService_URL = 'http://testws.baroservice.com/FAX.asmx?WSDL';	//테스트베드용
//$BaroService_URL = 'http://ws.baroservice.com/FAX.asmx?WSDL';		//실서비스용

$BaroService_FAX = new SoapClient($BaroService_URL, array(
	'trace' => 'true',
	'encoding' => 'UTF-8' //소스를 ANSI로 사용할 경우 euc-kr로 수정
));
					
function getErrStr($CERTKEY, $ErrCode){
	global $BaroService_FAX;

	$ErrStr = $BaroService_FAX->GetErrString(array(
		'CERTKEY' => $CERTKEY,
		'ErrCode' => $ErrCode
	))->GetErrStringResult;

	return $ErrStr;
}
?>
