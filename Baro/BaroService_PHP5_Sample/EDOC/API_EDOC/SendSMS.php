<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>SendSMS - 문자 전송</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$MgtKey = '';			//연동사부여 문서키
	$FromNumber = '';		//발신자 휴대폰 번호
	$ToNumber = '';			//수신자 휴대폰 번호
	$Contents = '';			//문자메세지 내용

	$Result = $BaroService_EDOC->SendSMS(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'UserID'		=> $ID,
		'MgtKey'		=> $MgtKey,
		'FromNumber'	=> $FromNumber,
		'ToNumber'		=> $ToNumber,
		'Contents'		=> $Contents
	))->SendSMSResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
