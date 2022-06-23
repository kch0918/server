<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>CancelReservedSMSMessage - 예약 전송취소</p>
<div class="result">
	<?php
    $CERTKEY = '';		//인증키
    $CorpNum = '';		//바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
    $SendKey = '';		//바로빌부여 전송키

	$Result = $BaroService_SMS->CancelReservedSMSMessage(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'SendKey'	=> $SendKey
	))->CancelReservedSMSMessageResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>

