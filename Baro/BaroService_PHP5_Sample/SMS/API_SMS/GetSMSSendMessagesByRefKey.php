<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_SMS.php'; ?>
<p>GetSMSSendMessagesByRefKey - 문자 메시지 확인 (연동사부여 전송키)</p>
<div class="result">
	<?php
	$CERTKEY = '';		//인증키
	$CorpNum = '';      //바로빌 회원 사업자번호 ('-' 제외, 10자리) 		
	$RefKey = '';       //연동사부여 전송키

	$Result = $BaroService_SMS->GetSMSSendMessagesByRefKey(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'RefKey'	=> $RefKey
	))->GetSMSSendMessagesByRefKeyResult->SMSMessage;

	if (!is_array($Result) && $Result->SendState < 0){ //실패
		echo $Result->SendState;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
