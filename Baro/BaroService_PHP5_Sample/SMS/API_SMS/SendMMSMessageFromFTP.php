<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>SendMMSMessageFromFTP - 포토(MMS) 발송 (FTP)</p>
<div class="result">
	<?php
	//바로빌로부터 부여받은 FTP에 FileName 의 이름으로 JPG 파일을 업로드하는 코드를 구현한다.

	$CERTKEY = '';		//인증키
	$CorpNum = '';      //바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$SenderID = '';     //바로빌 회원 아이디
	$FromNumber = '';   //발신번호
	$ToName = '';       //수신자명
	$ToNumber = '';     //수신번호
	$Subject = '';      //제목
	$Contents = '';     //내용
	$FileName = '';     //전송할 파일명
	$SendDT = '';       //전송일시 (yyyyMMddHHmmss 형식) (빈 문자열 입력시 즉시 전송, 미래일자 입력시 예약 전송)
	$RefKey = '';       //연동사부여 전송키

	$Result = $BaroService_SMS->SendMMSMessageFromFTP(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SenderID'		=> $SenderID,
		'FromNumber'	=> $FromNumber,
		'ToName'		=> $ToName,
		'ToNumber'		=> $ToNumber,
		'TXTSubject'	=> $Subject,
		'TXTMESSAGE'	=> $Contents,
		'ImageFileName'	=> $FileName,
		'SendDT'		=> $SendDT,
		'RefKey'		=> $RefKey
	))->SendMMSMessageFromFTPResult;

	echo $Result;	
	?>
</div>
<?php include '../../_include/bottom.php'; ?>

