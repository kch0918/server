<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>SendMessages - 다량전송</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$SenderID = '';         //바로빌 회원 아이디
	$SendCount = 2;         //전송건수
	$CutToSMS = false;      //90 byte 보다 긴 내용의 문자인 경우 SMS 로 잘라서 전송할지 여부
	$Messages = array(		//메세지 정보 배열
		'XMSMessage'	=> array(
			array(
				'SenderNum'		=> "",	//발신번호
				'ReceiverName'	=> "",	//수신자명
				'ReceiverNum'	=> "",	//수신번호
				'Message'		=> "",	//내용
				'RefKey'		=> ""	//연동사부여 전송키
			),
			array(
				'SenderNum'		=> "", 
				'ReceiverName'	=> "", 
				'ReceiverNum'	=> "", 
				'Message'		=> "", 
				'RefKey'		=> ""
			)
		)
	);						
	$SendDT = '';           //전송일시 (yyyyMMddHHmmss 형식) (빈 문자열 입력시 즉시 전송, 미래일자 입력시 예약 전송)

	$Result = $BaroService_SMS->SendMessages(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SenderID'		=> $SenderID,
		'SendCount'		=> $SendCount,
		'CutToSMS'		=> $CutToSMS,
		'Messages'		=> $Messages,
		'SendDT'		=> $SendDT
	))->SendMessagesResult;

	echo $Result;	
	?>
</div>
<?php include '../../_include/bottom.php'; ?>

