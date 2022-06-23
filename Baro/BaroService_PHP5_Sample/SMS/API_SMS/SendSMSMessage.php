<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>SendSMSMessage - 단문(SMS) 발송</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';		//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$SenderID = '';		//바로빌 회원 아이디
	$FromNumber = '';	//발신번호
	$ToName = '';		//수신자명
	$ToNumber = '';		//수신번호
	$Contents = '';		//내용
	$SendDT = '';		//전송일시 (yyyyMMddHHmmss 형식) (빈 문자열 입력시 즉시 전송, 미래일자 입력시 예약 전송)
	$RefKey = '';		//연동사부여 전송키

	$Result = $BaroService_SMS->SendMessage(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SenderID'		=> $SenderID,
		'FromNumber'	=> $FromNumber,
		'ToName'		=> $ToName,
		'ToNumber'		=> $ToNumber,
		'Contents'		=> $Contents,
		'SendDT'		=> $SendDT,
		'RefKey'		=> $RefKey,
	))->SendMessageResult;

	echo $Result;	
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
