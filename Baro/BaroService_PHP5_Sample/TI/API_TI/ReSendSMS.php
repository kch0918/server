<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>ReSendSMS - 문자 재전송</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리) 			
	$SenderID = '';			//바로빌 회원 아이디	
	$FromNumber = '';		//발신자 휴대폰 번호
	$ToCorpName = '';		//수신자 회사명
	$ToName = '';			//수신자 이름
	$ToNumber = '';			//수신자 휴대폰 번호
	$Contents = '';			//문자메세지 내용

	$Result = $BaroService_TI->ReSendSMS(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'SenderID'		=> $SenderID,
		'FromNumber'	=> $FromNumber,
		'ToCorpNum'		=> $ToCorpName,
		'ToName'		=> $ToName,
		'ToNumber'		=> $ToNumber,
		'Contents'		=> $Contents
	))->ReSendSMSResult;
	
	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
