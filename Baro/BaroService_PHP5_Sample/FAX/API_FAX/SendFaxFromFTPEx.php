<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_FAX.php'; ?>
<p>SendFaxFromFTPEx - 전송 (다량파일)</p>
<div class="result">
	<?php
	//바로빌로부터 부여받은 FTP에 FileNames 의 이름으로 JPG 파일을 업로드하는 코드를 구현한다.

	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$SenderID = '';			//바로빌 회원 아이디
	$FileCount = 2;			//전송할 파일수
	$FileNames = array(		//전송할 파일명 배열
		'',
		''
	);
	$FromNumber = '';		//발신번호
	$ToNumber = '';			//수신번호
	$ToCorpName = '';		//수신자 회사명
	$ToName = '';			//수신자명
	$SendDT = '';			//전송일시 (yyyyMMddHHmmss 형식) (빈 문자열 입력시 즉시 전송, 미래일자 입력시 예약 전송)
	$RefKey = '';			//연동사부여 전송키
	
	$Result = $BaroService_FAX->SendFaxFromFTPEx(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SenderID'		=> $SenderID,
		'FileCount'		=> $FileCount,
		'FileNames'		=> $FileNames,
		'FromNumber'	=> $FromNumber,
		'ToNumber'		=> $ToNumber,
		'ReceiveCorp'	=> $ToCorpName,
		'ReceiveName'	=> $ToName,
		'SendDT'		=> $SendDT,
		'RefKey'		=> $RefKey
	))->SendFaxFromFTPExResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>