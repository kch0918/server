<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>SendFaxesFromFTP - 다량전송 (단일파일)</p>
<div class="result">
	<?php
	//바로빌로부터 부여받은 FTP에 FileName 의 이름으로 JPG 파일을 업로드하는 코드를 구현한다.

	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$SenderID = '';			//바로빌 회원 아이디
	$FileName = '';			//전송할 파일명
	$SendCount = 2;			//전송건수
	$Messages = array(		//팩스 배열
		'FaxMessage'	=> array(
			array(
				'SenderNum'			=> '',	//발신번호
				'ReceiverNum'		=> '',	//수신번호
				'ReceiveCorp'		=> '',	//수신자 회사명
				'ReceiverName'		=> '',	//수신자명
				'RefKey'			=> '',	//연동사부여 전송키
				'SendPageCount'		=> 0,	//별도 수정이 필요하지 않음.
				'SuccessPageCount'	=> 0,	//별도 수정이 필요하지 않음.
				'SendState'			=> 0	//별도 수정이 필요하지 않음.
			),
			array(
				'SenderNum'			=> '', 
				'ReceiverNum'		=> '', 
				'ReceiveCorp'		=> '', 
				'ReceiverName'		=> '', 
				'RefKey'			=> '',
				'SendPageCount'		=> 0,	
				'SuccessPageCount'	=> 0,
				'SendState'			=> 0
			)
		)
	);
	$SendDT = '';			//전송일시 (yyyyMMddHHmmss 형식) (빈 문자열 입력시 즉시 전송, 미래일자 입력시 예약 전송)

	$Result = $BaroService_FAX->SendFaxesFromFTP(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SenderID'		=> $SenderID,
		'FileName'		=> $FileName,
		'SendCount'		=> $SendCount,
		'Messages'		=> $Messages,
		'SendDT'		=> $SendDT						
	))->SendFaxesFromFTPResult->string;

	if ($Result < 0) {
		echo $Result;
	}else{
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>